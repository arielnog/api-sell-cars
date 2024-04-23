## Compatibilidade

- PHP >= 8.1
- Laravel >= 9.52.16
- Composer >= 2.5.8

## Ambiente

- PHP 8.2.9
- Nginx 1.24.0
- PostgreSQL 16.1
- MongoDB 7.0
- Redis 7.2.0

## Iniciando o projeto

Criar o arquivo `.env` no projeto
```bash
php -r "copy('.env.example', '.env');"
```
Criar uma network (caso não esteja criada)
```bash
docker network create global-default
```
Faça o build dos containeres no `docker-compose` no diretório raiz:
```bash
docker-compose up -d --build
```

## Executando testes automatizados

Execute as migrations com os dados das seeds
```bash
php artisan migrate:fresh --seed
```
Rode o script para execução dos testes automatizados
```bash
php artisan test
```

## Serviços e Portas

| Container                   | Host Port | Container Port (Internal) |
| --------------------------- | --------- | ------------------------- |
| customer_manager_app        | `9501`    | `9501`                    |
| customer_manager_nginx      | `8080`    | `80`                      |
| customer_manager_postgres   | `5432`    | `5432`                    |
| customer_manager_redis      | `6379`    | `6379`                    |

## Health

Endpoint que validam a saúde da aplicação e dos serviços:

- `http://localhost:8080/health`

