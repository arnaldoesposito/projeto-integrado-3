FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Remove mpm_event diretamente para evitar conflito
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
          /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork rewrite

# Apontar document root para public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
        /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>' \
       >> /etc/apache2/apache2.conf

COPY . /var/www/html/

EXPOSE 80
