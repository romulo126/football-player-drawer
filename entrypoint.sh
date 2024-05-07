#!/bin/bash
set -e

echo "Iniciando a instalação das dependências do Composer..."
cd /var/www/html && composer install

echo "Copiando o .env.example para .env
cp /var/www/html/.env.example /var/www/html/.env

echo "Executando teste do Laravel..."
php artisan test

echo "Executando migrações do Laravel..."
php artisan migrate

echo "Iniciando o laravel service..."
php /var/www/html/artisan serve --host=0.0.0.0 --port=80