FROM debian:buster

RUN apt-get update && \
    apt-get install -y make apache2 php7.3 \
    libapache2-mod-php7.3 \
    make \
    curl \
    git \
    zip \
    unzip \
    sqlite3 \
    php7.3-sqlite

RUN a2enmod php7.3

WORKDIR /var/www/html

RUN rm *
RUN git clone https://github.com/dbwebb-se/itsec-app.git .

RUN curl -sS https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer && \
chmod +x /usr/local/bin/composer

RUN composer update && composer install

RUN mkdir data && touch data/db.sqlite
RUN chmod -R 777 data
RUN sqlite3 data/db.sqlite < sql/uber.sql
WORKDIR sql
RUN ["/bin/bash", "-c", "./dummy.bash"]
RUN ["/bin/bash", "-c", "sqlite3 ../data/db.sqlite < test.sql"]


RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN a2enmod rewrite

CMD apache2ctl -D FOREGROUND
