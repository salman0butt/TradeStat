#!/bin/bash

# Generate the application key if it doesn't exist
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction --no-dev
fi

# Generate the .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan serve --port=$PORT --host=127.0.0.1 --env=.env
    exec docker-php-entrypoint "$@"
fi
