FROM wordpress:latest

RUN apt-get update || apt-get update
RUN apt-get install -y git zlib1g-dev

RUN docker-php-ext-install pdo pdo_mysql zip \
 && a2enmod rewrite \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp
RUN apt-get install nano
RUN apt-get install -y mysql-client
WORKDIR /var/www/html

EXPOSE 80 443