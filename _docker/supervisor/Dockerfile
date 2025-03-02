FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y supervisor && docker-php-ext-install pdo pdo_mysql

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]

WORKDIR /var/www