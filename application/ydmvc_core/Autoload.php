<?php
/**
 * The Autoload class is a static class that contains methods
 * to automatically load class files when required by the application
 * 
 * The methods are added to the SPL_autoload_register to be registered
 * as autoload implementations and look for classes in different areas
 * of the framework
 * 
 * @category Core
 * @example spl_autoload_register('Autoload::coreLoader');
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net> 
 */
class Autoload {

  /**
   * Autoloads classes in the framework's core directory. looks for
   * a file with the same name as the class being called; the class
   * and filename should match and be title case e.g. Example.php
   *  
   * @param string $className The name of the class being called
   */
  public static function coreLoader($className) {
      $filename = 'application/ydmvc_core/'.$className.'.php';
       if (is_readable($filename)) {
          require_once $filename;
       }
  }
  
  /**
   * Autoloads classes in the framework's controller directory. looks for
   * a file with the same name as the class being called; the class
   * and filename should match and be title case e.g. Example.php
   *  
   * @param string $className The name of the class being called
   */
  public static function controllerLoader($className) {
      $filename = 'application/controllers/'.$className.'.php';
       if (is_readable($filename)) {
          require_once $filename;
       }
  }
  
  /**
   * Autoloads classes in the framework's model directory. looks for
   * a file with the same name as the class being called; the class
   * and filename should match and be title case e.g. Example.php
   *  
   * @param string $className The name of the class being called
   */
  public static function modelLoader($className) {
      $filename = 'application/models/'.$className.'.php';
       if (is_readable($filename)) {
          require_once $filename;
       }
  }
}
?>
