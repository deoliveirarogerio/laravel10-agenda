# Usar imagem oficial do PHP com suporte ao Laravel
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    vim \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto
COPY . .

# Instalar dependências do Laravel
RUN composer install

# Permitir acesso às pastas de cache e storage
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
