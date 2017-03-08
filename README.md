# symfony-blog - Simple Symfony3 Blog Application 

## Description
Lightweight and easy-to-use Blog solution for PHP using Symfony3 framework.

## Requirements
* PHP 5.5.9 or higher;
* MySQL
* and the [usual Symfony application requirements](http://symfony.com/doc/current/reference/requirements.html).

## Quickstart - Installation
Download and install the blog application using Git and Composer:

```bash
$ git clone https://github.com/bkazuo/symfony-blog.git
$ cd symfony-blog/
$ composer install
```
> **NOTE**
>
> You may need to give cache, logs and session folders write permissions
>
>     symfony-blog$ chmod -R 777 var/cache var/logs var/sessions

## Create and Update database
```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

Usage
-----

There is no need to configure a virtual host in your web server to access the application.
Just use the built-in web server:

```bash
symfony-blog$ php bin/console server:run
```
