<?php


/*
ENTER YOUR SERVER URL, BASE_URL should be root of your server
*/
define('BASE_URL', 'http://localhost');


/**
 * Database Configuration
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 'localhost');
define('DB_DATABASE', 'catalog');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

/**
 * Name of Site
 */
define('SITE_TITLE', "Catalog");

/**
 * Name of user session
 */
define('SESSION_USER', "user");


/**
 * Theme configuration
 */

define('DEFAULT_LAYOUT', 'default');

/** 
 * Path to asset folder
 */
define('ASSET_URL',  '/');

/** 
 * Path to views folder
 */
define('VIEW_PATH', '../resources/views/');

/** 
 * Error reporting level .
 */
define('ERROR_REPORTING', 0);
