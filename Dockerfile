FROM php:8.2-apache
# Instala la extensión mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# Copia tus archivos al servidor
COPY . /var/www/html/
# Da permisos
RUN chown -R www-data:www-data /var/www/html