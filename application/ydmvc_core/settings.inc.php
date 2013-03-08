<?php
//leave alone - for dev purposes only - git control
@include('local.settings.php');

//PHP display errors setting. Set 0 for production and 1 for development (won't hide fatal errors)
ini_set('display_errors', '0');

//Server document path to the application
define('SERVER_ROOT', '/var/html/');

//Set the base application url
define('SITE_ROOT', 'http://localhost');

//define default controller and method (e.g. landing page)
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');

//Database connection strings
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'database');
define('DB_HOST', 'localhost');
//DSN for PDO modify for different DB types
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

//view settings - true to use template.html file in view folder
define('USE_TEMPLATE',TRUE);
?>
