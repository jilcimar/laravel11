# Projeto Laravel 11 com Docker

Este projeto utiliza Laravel 11 e está configurado para ser executado em um ambiente Docker. Siga as instruções abaixo para configurar e executar o projeto corretamente.

## Pré-requisitos

Certifique-se de ter os seguintes requisitos instalados em sua máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Instruções de Configuração

1. **Copiar o arquivo `.env.example`**

   No diretório raiz do projeto, copie o arquivo `.env.example` para `.env` com o seguinte comando:

   ```bash
   cp .env.example .env
   ```

2. **Subir os containers com Docker Compose**

   Inicie os containers necessários para o projeto com o comando:

   ```bash
   docker-compose up -d
   ```

   Esse comando iniciará os serviços definidos no arquivo `docker-compose.yml`, incluindo o container do Laravel e o banco de dados.

3. **Instalar as dependências do Composer**

   Entre no container da aplicação Laravel com o seguinte comando:

   ```bash
   docker exec -it laravel-app bash
   ```

   Substitua `<nome_do_container_laravel>` pelo nome do container configurado no arquivo `docker-compose.yml` (por exemplo, `laravel.test`). Depois de entrar no container, execute:

   ```bash
   composer install
   ```

4. **Executar as migrações do banco de dados**

   Ainda dentro do container, execute o comando abaixo para aplicar as migrações:

   ```bash
   php artisan migrate
   ```

5. **Acessar a aplicação**

   A aplicação estará disponível no navegador pelo endereço:

   ```
   http://localhost
   ```

   Certifique-se de verificar a porta configurada na variável `APP_PORT` do arquivo `.env`. Se não estiver definida, a porta padrão será `80`.

## Estrutura do Projeto

- **Aplicação Laravel**: `laravel.test`
- **Banco de Dados**: `postgres` (PostgreSQL configurado no `docker-compose.yml`)

Certifique-se de configurar corretamente as variáveis de ambiente no arquivo `.env` para conectar ao banco de dados.

## Observação

Caso encontre problemas ao subir os containers ou executar os comandos acima, revise os logs do Docker e certifique-se de que todas as variáveis de ambiente estão configuradas corretamente no arquivo `.env`.
