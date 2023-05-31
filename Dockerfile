# Build stage
FROM php:8.1 as php

# Install build dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip && docker-php-ext-install zip

ENV PORT=8000

EXPOSE 8000

# Set the working directory
WORKDIR /var/www

# Install Composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Copy the rest of the application code
COPY . .

# Copy the entrypoint
COPY ./Docker/entrypoint.sh .

# Correct line endings and permissions if running on a Windows host
RUN tr -d '\r' <entrypoint.sh >/tmp/entrypoint.sh
RUN chmod 755 /tmp/entrypoint.sh

# RUN entrypoint
CMD /tmp/entrypoint.sh
