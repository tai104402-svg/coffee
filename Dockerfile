
FROM php:8.2-apache

# Enable mod_rewrite (cần cho MVC routing)
RUN a2enmod rewrite

# Cài extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql

# Set thư mục làm việc
WORKDIR /var/www/html

# Copy TOÀN BỘ project vào container
COPY . /var/www/html

# Set document root về thư mục public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Cập nhật Apache config để dùng public/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
=======# Dùng PHP + Apache
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
>>>>>>> dcea8e81e23200a1ef932b7761314d51206950ef
