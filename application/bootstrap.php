<?php
//include core settings
require_once 'ydmvc_core/settings.inc.php';

//autoload required classes
require 'ydmvc_core/Autoload.php';
spl_autoload_register('Autoload::coreLoader');
spl_autoload_register('Autoload::controllerLoader');
spl_autoload_register('Autoload::modelLoader');

//call the router to load the controller
$frontController = new FrontController();
$frontController->run();
?>
