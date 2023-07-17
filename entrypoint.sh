#!/bin/bash

# Install mysqli extension
docker-php-ext-install mysqli
docker-php-ext-enable mysqli

# Restart Apache service
service apache2 restart

# Execute the CMD defined in the Dockerfile
exec "$@"
