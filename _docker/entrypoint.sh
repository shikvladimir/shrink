#!/bin/bash

source ./_docker/.env

if [ ! -f .env ]; then
    cp .env.example .env

    sed -i "s/^APP_NAME=.*/APP_NAME=$APP_NAME/" .env

    sed -i "s/^DB_HOST=.*/DB_HOST=db/" .env
    sed -i "s/^DB_PORT=.*/DB_PORT=3306/" .env
    sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/^DB_USERNAME=.*/DB_USERNAME=root/" .env
    sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env

    sed -i "s/^REDIS_HOST=.*/REDIS_HOST=redis/" .env
    sed -i "s/^REDIS_PORT=.*/REDIS_PORT=$REDIS_PORT/" .env

    php artisan key:generate
fi

#chown -R www-data:www-data /var/www
#chmod -R 775 /var/www

#apt-get update && apt-get install -y screen
#su - www-data -c "screen -dmS npm_dev npm run dev"

exec php-fpm