# Dùng PHP + Apache
FROM php:8.1-apache

# Bật mod rewrite
RUN a2enmod rewrite

# Set thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ source code vào container
COPY . /var/www/html

# Apache trỏ document root về thư mục public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cấp quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose cổng 80
EXPOSE 80
