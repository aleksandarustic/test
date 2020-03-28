# TEST (CATALOG)

A simple PHP MVC user authentication application. I’ve used this as a starter framework for some of my own PHP applications. This would be useful for small projects. It will be advantageous if you know the basics of object-oriented programming and MVC and you are able to use the command line. This script is not for beginners.

## Requirements
* PHP 7+
* MySQL

## Installation
* Make sure you have Apache, PHP, MySQL installed.
* Clone this repo to a folder on your server.
* Activate mod_rewrite.
* Edit config/config.php and set your database credentials and BASE_URL to root of your server.
* Import database from catalog.sql file

### Install Composer
Go to project folder and run the composer install command;

```bash
composer install
```

### Install Database
Execute the SQL statements via phpmyadmin or the command line. In the following example "root", "password", "myApp" are the username, password and database name.

```bash
cat _install/db01-structure.sql | mysql --user=root --password=password myApp
cat _install/db02-constraints.sql | mysql --user=root --password=password myApp
cat _install/db03-inserts.sql | mysql --user=root --password=password myApp
```