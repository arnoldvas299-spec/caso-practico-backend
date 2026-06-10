FROM php:8.2-apache

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias de PHP (Dompdf)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear directorio de reportes con permisos
RUN mkdir -p /var/www/html/reports && chmod 755 /var/www/html/reports

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto (Render usa la variable PORT)
EXPOSE 10000

# Script de inicio: configurar Apache para usar el puerto de Render
CMD sed -i "s/Listen 80/Listen ${PORT:-10000}/" /etc/apache2/ports.conf && \
    sed -i "s/:80/:${PORT:-10000}/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground
