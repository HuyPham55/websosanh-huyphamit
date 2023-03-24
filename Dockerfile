#04092022: Dockerfile for Laravel project with `vendor` directory (dependencies installed)
#04092022: To run Laravel project without project dependencies installed already, run composer install manually
#10112022: Optimized config for working with images and PDF
#23022023: Allow composer require package by adding zip package and extension

FROM devilbox/php-fpm-8.0:latest

# Copy composer.lock and composer.json
COPY composer.json /var/www/

# Set working directory
WORKDIR /var/www

#28042022: Change user to root (super user)
#[pool www] 'user' directive is ignored when FPM is not running as root
USER root

# Install dependencies
# JPEG images included
RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

#### Install all PDF dependencies
RUN apt-get install -y \
    libxrender1 \
    libfontconfig1 \
    libx11-dev \
    libjpeg62 \
    libxtst6 \
    wget \
    && wget https://github.com/h4cc/wkhtmltopdf-amd64/blob/master/bin/wkhtmltopdf-amd64?raw=true -O /usr/local/bin/wkhtmltopdf \
    && chmod +x /usr/local/bin/wkhtmltopdf
    # https://github.com/barryvdh/laravel-snappy/issues/68


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql exif pcntl

RUN apt-get update && apt-get install -y zip git unzip
RUN apt-get install -y libzip-dev
#https://stackoverflow.com/questions/45775877/configure-error-please-reinstall-the-libzip-distribution
RUN docker-php-ext-install zip
#RUN docker-php-ext-install mbstring


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
