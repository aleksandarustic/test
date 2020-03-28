<?php

use Lib\Router;

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../lib/functions.php';

require __DIR__ . '/../vendor/autoload.php';

session_start();

error_reporting(ERROR_REPORTING);

$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'], '/')) : [];

Router::route($url);
