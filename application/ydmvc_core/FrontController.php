<?php
/**
 * The FrontController class is the heart of the framework interpreting
 * requests and dispatching appropriate controllers
 * 
 * It calls the Request Class to extract parameters from the url
 * and instantiates the appopriate controller, including the method
 * and any parameters
 * 
 * @category Core
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net> 
 * 
 */
class FrontController {
    
    /**
     * The Controller being called
     * @var string
     */
    private $controller;
    /**
     * The Method being called
     * @var string
     */
    private $method;
    /**
     * Array of parameters being passed to controller
     * @var array 
     */
    private $values = array();
    
    /**
     * Constructor instantiates request object to gather request
     * parameters then calls appropriate controller
     */
    function __construct() {
        
        $request = new Request();//request object decodes url
        
        //set controller,method and value properties
        if (!is_null($request->controller)) {
            $this->controller = $request->controller;
         }
        if (isset($request->method)) {
            $this->method = $request->method;
        }
        if (isset($request->values)) {
            $this->values = $request->values;
        }
        
        $this->controller(); //call controller method
    }
    
    /**
     * Creates a new instance of the controller being called
     * by the url request
     */
    public function controller() {
      $className = ucwords($this->controller) . '_Controller';
      new $className($this->method,$this->values);
    }
    
}
?>
