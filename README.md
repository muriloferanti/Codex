
# Laravel Ollama Parser

Projeto em Laravel que consome modelos locais do Ollama via [TransformersPHP](https://github.com/codewithkyrian/transformers) para realizar parsing e interpretação de prescrições médicas em HTML, estruturando os dados em JSON.

## 🚀 Tecnologias

- PHP 8.2+
- Laravel 12
- [TransformersPHP](https://github.com/codewithkyrian/transformers) (para consumir modelos do Ollama)
- Ollama (LLM local)
- Docker (opcional, para ambiente isolado)

## 🩺 Funcionalidade Principal

Este projeto recebe um HTML de uma prescrição médica como input, interpreta os dados utilizando um modelo LLM local (Ollama), e retorna um JSON estruturado contendo informações como:

- Medicamentos
- Dosagens
- Posologias
- Frequências
- Observações

## ⚙️ Requisitos

- PHP 8.2 ou superior
- Composer
- Python 3 (para instalar dependências do Transformers)
- Ollama instalado localmente (https://ollama.com/)
- Docker (opcional)

## 📦 Instalação

### 🔧 Clone o projeto

```bash
git clone git@github.com:seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 🐘 Instale as dependências PHP

```bash
composer install
```

### 🐍 Instale dependências Python (para Transformers)

```bash
python3 -m venv /venv
source /venv/bin/activate
pip install -r requirements.txt
```

Ou diretamente:

```bash
pip install transformers torch
```

### 🔑 Copie o arquivo de ambiente

```bash
cp .env.example .env
```

### 🔐 Gere a chave da aplicação

```bash
php artisan key:generate
```

### 🏗️ Rode as migrations (se houver)

```bash
php artisan migrate
```

### 🚀 Suba o servidor

```bash
php artisan serve
```

## 🧠 Configuração do Ollama

1. Instale o Ollama: https://ollama.com/download  
2. Baixe o modelo desejado (ex.: `llama3`, `phi3`, `mistral`):  

```bash
ollama pull llama3
```

3. Certifique-se de que o Ollama está rodando localmente na porta padrão `11434`.

## 🔥 Executando a API

Exemplo de requisição para interpretar um HTML:

```bash
curl --request POST \
  --url http://127.0.0.1:8000/api/parser \
  --header 'Content-Type: application/json' \
  --data '{
	"html": "<html>... conteúdo da prescrição ...</html>"
}'
```

### ✅ Retorno esperado:

```json
{
  "medications": [
    {
      "name": "Paracetamol",
      "dosage": "500mg",
      "frequency": "2x ao dia",
      "observation": "Após refeições"
    }
  ]
}
```

## 🐳 Usando com Docker (opcional)

```bash
docker compose up --build
```

## 📜 Licença

Este projeto está licenciado sob a licença MIT.

## 🤝 Autor

Desenvolvido por [Murilo Feranti](https://github.com/muriloferanti) com ❤️ e café.
