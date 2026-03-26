FROM php:8.2-apache

# Instalamos la extensión mysqli de forma limpia
RUN docker-php-ext-install mysqli

# Aseguramos que los archivos se copien a la carpeta correcta
COPY . /var/www/html/

# Ajustamos los permisos para que Apache pueda leer todo
RUN chown -R www-data:www-data /var/www/html