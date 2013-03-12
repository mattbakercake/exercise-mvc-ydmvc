<?php
/**
 * The FrontController class is the heart of the framework interpreting
 * requests and dispatching appropriate controllers
 * 
 * It determines whether controller/action/parameters have been passed to it 
 * and either sets these values or calls the Request Class to extract the values
 * from the url.  The run method dispatches the controller.
 * 
 * @category Core
 * @version 0.2
 * @since 05-03-2013
 * @author Matt Baker <dev@mikesierra.net> 
 * 
 */
class FrontController {
    
    /**
     * The controller being called
     * @var string
     */
    private $_controller;
    /**
     * The action being called
     * @var string
     */
    private $_action;
    /**
     * Array of parameters being passed to controller
     * @var array 
     */
    private $_params = array();
    
    /**
     * Constructor determines whether controller/action/parameters have been
     * passed to it and either sets controller/action/parameters or
     * parses the url to get this information.
     * 
     * @param Array $options Array of front controller options e.g. 
     * ('controller'=>'index','action'=>'showusers','params'=>array('1','2'))
     * 
     * @example
     *  $FrontController = new FrontController();<br/>
     *      ##OR##<br/>
     *  $FrontController = new FrontController(array(<br/>
     *                                          'controller'=>'index',<br/>
     *                                          'action'=>'showusers',<br/>
     *                                          'params=>array('1','2')<br/>
     *                                         ));<br/>
     */
    function __construct(array $options = array()) {
        
        if (empty($options)) { //if no options passed to object
            $request = new Request();//request object decodes url
        
            //set controller,action and value properties
            if (!is_null($request->controller)) {
                $this->_controller = $request->controller;
             }
            if (isset($request->action)) {
                $this->_action = $request->action;
            }
            if (isset($request->params)) {
                $this->_params = $request->params;
            }
        } else { //if options have been passed to object set them
           if (isset($options['controller'])) {
               $this->_controller = $options['controller'];
           }
           if (isset($options['action'])) {
               $this->_action = $options['action'];
           }
           if (isset($options['params'])) {
               $this->_params = $options['params'];
           }
           
        }
    }
    
    
    /**
     * Runs the front controller for request.  Creates a new instance of 
     * the controller and action that has been set
     * by the url request
     */
    private function _instantiateContoller() {
        //check controller is set
        if (!isset($this->_controller)) { 
            throw new Exception('Controller not specified in front controller');
        }
        //check action is set
        if (!isset($this->_action)) { 
            throw new Exception('Controller action not specified in front controller');
        }
        //set controller class/file name
        $className = ucwords($this->_controller) . '_Controller';
        //check controller class file/class exists/is readable
        if (!class_exists($className)) {
            //if display errors are off (production environment) throw 404 page else throw exception
            if (ini_get('display_errors') === '0') {
                $e = new Error();
                $e->_throw404();
            } else {
                throw new Exception('Controller class not defined: '.$className. ' ');
            }
        }
        //check controller action is defined
        if (!method_exists($className, $this->_action)) {
            //if display errors are off (production environment) throw 404 page else throw exception
            if (ini_get('display_errors') === '0') {
                $e = new Error();
                $e->_throw404();
            } else {
                throw new Exception('Controller action not defined: Controller: '.$className. ' -> Action: ' .$this->_action);
            }
        }
        //if all above don't throw exception instantiate controller
        new $className($this->_action,$this->_params);  
        
    }
    
    /**
     * Dispatches front controller calling _instantiateContoller() function 
     * to fire current request or throws an error
     */
    public function run() {
        try {
          $this->_instantiateContoller();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
}
?>
