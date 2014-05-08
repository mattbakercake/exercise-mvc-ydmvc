<?php

//This is the base model class - all models must be extended from it
/**
 * The Model class is a base class from which all new models
 * must extend.
 * 
 * It contains methods and properties common to all models
 * 
 * @category Core
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net>
 */
abstract class Model {

    /**
     * Instance of view object
     * @var object
     */
    protected $_view;
    /**
     * Instance of controller object
     * @var object
     */
    protected $_controller;
    /**
     * String containing any error messages
     * @var String
     */
    public $errorInfo;
    /**
     * String containing repository object for model
     * @var String
     */
    public $_repository;
    
    /**
     * Constructor sets reference to currrent view and controller objects
     */
    function __construct($view = NULL,$controller = NULL) {
        
        //set view object if passed to constructor
        if (is_object($view)) {
            $this->_setView($view);
        }
        //set controller object if passed to constructor
        if (is_object($controller)) {
            $this->_setController($controller);
        }
     
        //set repository object if class exists
        $repoName = get_class($this) . "_Repository";

        if (class_exists($repoName)) {
            $this->_repository = new $repoName();
        }
  
    }
    
    /**
     * Sets $_view property with view object instance
     * @param object $view
     */
    private function _setView($view) {
        $this->_view = $view;
    }
    
    /**
     * Sets $_controller property with controller object instance
     * @param object $controller
     */
    private function _setController($controller) {
        $this->_controller = $controller;
    }
    

}
?>
