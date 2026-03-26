FROM php:8.2-apache

# Instalamos mysqli y forzamos a que no toque la configuración de Apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copiamos tus archivos
COPY . /var/www/html/

# Aseguramos permisos
RUN chown -R www-data:www-data /var/www/html

# Exponemos el puerto que usa Railway
EXPOSE 80