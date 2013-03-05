<?php
//PHP display errors setting. Set 0 for production and 1 for development (won't hide fatal errors)
ini_set('display_errors', '1');

//Server document path to the application
define('SERVER_ROOT', '/web/vhosts/dev/ydmvc');

//Set the base application url
define('SITE_ROOT', 'http://dev.internal.mikesierra.plus.com/ydmvc');

//define default controller and method (e.g. landing page)
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');

//Database connection strings
define('DB_USERNAME', 'ydmvcuser');
define('DB_PASSWORD', 'ydmvcuserp455word');
define('DB_NAME', 'ydmvc');
define('DB_HOST', 'localhost');
//DSN for PDO modify for different DB types
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

//view settings
define('USE_TEMPLATE',TRUE);

?>
