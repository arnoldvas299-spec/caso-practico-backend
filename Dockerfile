FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/

RUN a2enmod rewrite

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/app.conf \
    && a2enconf app

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
