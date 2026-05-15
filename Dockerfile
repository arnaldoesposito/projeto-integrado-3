FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Remove todos os módulos MPM e ativa só o prefork
RUN find /etc/apache2/mods-enabled -name 'mpm_*' -delete \
    && ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && a2enmod rewrite

# Apontar document root para public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# Permitir .htaccess em public/
RUN printf '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
    >> /etc/apache2/apache2.conf

COPY . /var/www/html/

EXPOSE 80
