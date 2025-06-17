<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kyrian\Transformers\Transformers;

class ClassifyTextCommand extends Command
{
    protected $signature = 'nlp:classify {text}';
    protected $description = 'Classifica um texto usando IA (transformers-php)';

    public function handle(): void
    {
        $text = $this->argument('text');

        $pipeline = Transformers::pipeline('sentiment-analysis');
        $result = $pipeline->run($text);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}
