Symfony Blog Application
========================

The "Symfony Blog Application" is a basic application created to generate CRUD in symfony.

Requirements
------------

  * PHP 7.4
  * Composer 2.5.8
  * Mysql8
  * Node 20.10.0
  * NPM 10.2.3


Installation
------------
1. git clone https://github.com/devphp06/symfony-blog.git
2. composer install
3. npm install
4. Copy .env-example and create .env file and update DB details.

To generate assets file
------------
1. npm run dev
2. php bin/console assets:install

To run local server
------------
1. php -S localhost:8000 -t public/