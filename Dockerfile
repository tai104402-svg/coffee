FROM php:8.2-apache

# Bật mod_rewrite cho MVC
RUN a2enmod rewrite

# Cài PDO + MySQL driver (QUAN TRỌNG)
RUN docker-php-ext-install pdo pdo_mysql

# Set thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ source code
COPY . /var/www/html

# Apache trỏ document root về public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
