import sys
import json
from transformers import pipeline

def main():
    html = sys.stdin.read()

    llm = pipeline("text-generation", model="meta-llama/Meta-Llama-3-8B")

    prompt = f"""
Você receberá o HTML de uma prescrição médica. Extraia e retorne um JSON estruturado contendo os dados dos medicamentos.

Formato esperado:

{{
  "medicaments": [
    {{
      "name": "Nome do medicamento",
      "quantity": "Quantidade",
      "posology": "Posologia"
    }}
  ],
  "total": número de itens encontrados
}}

HTML:
{html}
    """

    response = llm(prompt, max_length=1000)
    generated_text = response[0]['generated_text']

    try:
        start = generated_text.find('{')
        end = generated_text.rfind('}') + 1
        json_string = generated_text[start:end]
        data = json.loads(json_string)
    except Exception:
        data = {
            "error": "Failed to parse output",
            "raw_output": generated_text
        }

    print(json.dumps(data))

if __name__ == "__main__":
    main()
