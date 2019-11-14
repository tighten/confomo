#!/bin/bash

composer install
cp .env.example .env
php artisan key:generate
npm install
gulp
