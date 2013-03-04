<?php

//This is the base controller - all new controllers must extend this

/**
 * The Controller class is a base class from which all new controllers
 * must extend.
 * 
 * It contains methods and properties common to all controllers and is
 * responsible for instantiating model and view objects
 * 
 * @category Core
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net>
 */
class Controller {
    
    /**
     * Instance of model object for current request
     * @var Object
     */
    protected $model;
    /**
     * Instance of view object for current request
     * @var Object
     */
    protected $view;
    /**
     * Array containing parameters passed to controller
     * @var Array 
     */
    protected $urlValues;
    /**
     * String constaining the name of current model/view
     * class
     * @var string
     */
    private $modelViewName;
    /**
     * String containing the name of the current controller
     * @var string 
     */
    private $controllerName;
    

    /**
     * Constructor instantiates model and view objects and
     * calls the controller method to be run
     * @param string $method
     * @param array $urlValues
     */
    function __construct($method,$urlValues) {
        $this->setControllerName();
        $this->setModelViewName();
        $this->setUrlValues($urlValues);
        $this->loadModel();
        $this->loadView();
        $this->runControllerMethod($method);
    }
    
    /**
     * Instantiates current model object
     */
    protected function loadModel() {
        $this->model = new $this->modelViewName;
    }
    
    /**
     * Instantiates current view object
     */
    protected function loadView() {
        $this->view = new View($this->modelViewName);
    }
    
    /**
     * runs controller method
     * @param string $method
     */
    protected function runControllerMethod($method) {
        $this->$method();
    }
    
    /**
     * sets name of current controller
     */
    private function setControllerName() {
        $this->controllerName = get_called_class();
    }
    
    /**
     * sets name of current model/view
     */
    private function setModelViewName() {
        $modelViewName = preg_replace('/_Controller$/', '', $this->controllerName);
        $this->modelViewName = $modelViewName;
    }
    
    /**
     * sets array of parameters from url
     * @param array $urlValues
     */
    private function setUrlValues($urlValues) {
        $this->urlValues = $urlValues;
    }

}

?>
