FROM wordpress:latest

RUN apt-get update || apt-get update
RUN apt-get install -y libzip-dev git zlib1g-dev

# Set up SSL
RUN apt-get update && \
        apt-get install -y  --no-install-recommends ssl-cert && \
        rm -r /var/lib/apt/lists/* && \
        a2enmod ssl

RUN a2ensite default-ssl && service apache2 restart

RUN docker-php-ext-install pdo pdo_mysql zip \
 && a2enmod rewrite \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp
RUN apt-get update && apt-get install -y nano links mariadb-client
WORKDIR /var/www/html

EXPOSE 80 443

