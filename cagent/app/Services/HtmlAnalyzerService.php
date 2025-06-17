<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HtmlAnalyzerService
{
    protected string $ollamaHost;

    public function __construct()
    {
        $this->ollamaHost = config('services.ollama.host', 'http://ollama:11434');
    }

    public function analyze(string $html): array
    {
        $prompt = <<<EOT
            Você receberá o HTML de uma prescrição médica. Seu objetivo é extrair e retornar um JSON estruturado contendo os dados dos medicamentos.

            Formato esperado:

            {
                "medicaments": [
                    {
                        "name": "Nome do medicamento",
                        "quantity": "Quantidade, apenas o número",
                        "posology": "Posologia"
                    }
                ],
                "total": número de itens encontrados
            }

            Extraia apenas os medicamentos e seus dados. Retorne somente o JSON, sem explicações adicionais.

            HTML:
            $html
            EOT;

        try {
            $response = Http::timeout(300)
                ->post("{$this->ollamaHost}/api/generate", [
                    'model' => 'mistral',
                    'prompt' => $prompt,
                    'stream' => false,
                ]);

            if (!$response->successful()) {
                Log::error('Ollama API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'error' => 'Ollama API failed',
                    'details' => $response->body(),
                ];
            }

            $content = $response->json('response');

            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');

            if ($jsonStart === false || $jsonEnd === false) {
                return [
                    'error' => 'Failed to locate JSON in response',
                    'raw_output' => $content,
                ];
            }

            $jsonString = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);

            $result = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'error' => 'Failed to parse JSON',
                    'json_error' => json_last_error_msg(),
                    'raw_json' => $jsonString,
                    'raw_output' => $content,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Ollama request error', ['exception' => $e->getMessage()]);

            return [
                'error' => 'Exception during request',
                'details' => $e->getMessage(),
            ];
        }
    }
}
