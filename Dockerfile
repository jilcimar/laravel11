# Usar a imagem base do PHP
FROM php:8.2-fpm

# Instalar dependências necessárias para Composer
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Baixar e instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuração do diretório de trabalho
WORKDIR /var/www/html

# Expor a porta 80
EXPOSE 80

# Rodar o Laravel no servidor embutido do PHP na porta 80
CMD php artisan serve --host=0.0.0.0 --port=80
