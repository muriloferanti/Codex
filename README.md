# Laravel com Docker

Este repositório traz uma configuração básica para rodar um projeto Laravel usando Docker e Docker Compose. Ele inclui contêiner de aplicação (PHP), servidor web Nginx e banco de dados MySQL.

## Estrutura de Diretórios
```
.
├── docker-compose.yml
├── nginx/
│   └── default.conf
├── app/
└── ...
```
O código do Laravel deve ficar dentro da pasta `app/`.

## docker-compose.yml
O arquivo `docker-compose.yml` define três serviços principais:

- **app**: contêiner com PHP-FPM 8.1.
- **web**: contêiner com Nginx expondo a porta `8000`.
- **db**: contêiner com MySQL 8.

Já está configurado um volume para armazenar os dados do MySQL e um volume para mapear o código do projeto.

## Configuração do Nginx
O arquivo `nginx/default.conf` já contém uma configuração padrão para servir a aplicação Laravel.

## Como Usar
1. (Opcional) Se ainda não houver projeto Laravel na pasta `app/`, crie um:
   ```bash
   docker compose run --rm app composer create-project laravel/laravel .
   ```
2. Copie o arquivo `.env.example` para `.env` dentro da pasta `app/` e ajuste as variáveis de ambiente.
3. Suba os contêineres:
   ```bash
   docker compose up -d
   ```
4. Gere a chave da aplicação:
   ```bash
   docker compose exec app php artisan key:generate
   ```
5. A aplicação estará disponível em `http://localhost:8000`.

Com esses arquivos é possível iniciar rapidamente um ambiente de desenvolvimento para Laravel utilizando Docker.
