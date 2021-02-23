FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN apt install -y apt-utils procps nano
RUN apt install -y gnupg gnupg2 gnupg1 software-properties-common && apt remove yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /app
COPY . /app
RUN ls -alh
RUN composer clearcache
RUN composer install
CMD php artisan migrate:fresh --seed
CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181