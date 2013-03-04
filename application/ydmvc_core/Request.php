<?php
  
/**
 * The Request class parses the url and extracts the controller,
 * method and any parameters being requested
 *
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net>
 * 
 */
class Request {
    
    /**
     * The Controller being called. Defaults to DEFAULT_CONTROLLER
     * set in settings.inc.php file
     * @var string 
     */
    public $controller = DEFAULT_CONTROLLER;
     /**
     * The Method being called. Defaults to DEFAULT_METHOD
     * set in settings.inc.php file
     * @var string 
     */
    public $method = DEFAULT_METHOD;
     /**
     * An array of parameters extracted from url
     * @var array 
     */
    public $values = array();
     /**
     * Url that has been called
     * @var string 
     */
    private $url = NULL;
    
    /**
     * Constructor strips url of harmful html entities and extracts the requested 
     * Controller, Method and Parameters 
     */
    function __construct() {
        $this->cleanUrl();
        $this->request($this->url);
    }
    
    /**
     * private function extracts controller,method and parameters
     * from string separated by "/"
     * @param string $url
     */
    private function request($url) {
        $parameters = explode("/", $url);//split url into array
        
        //check array key for value - set class 
        //property and remove from array
        if (!empty($parameters[0])) {
           $this->controller = array_shift($parameters); 
        }
        
        if (!empty($parameters[0])) {
           $this->method = array_shift($parameters); 
        }
        
         if (!empty($parameters)) {
           $this->values = $parameters; 
        }
    }
    
    /**
     * Private function extracts url querystring and removes
     * unsafe html entites to prevent XSS
     */
    private function cleanUrl() {
        $url = NULL;
        if (isset($_GET['url'])) {
            $url = htmlentities(preg_replace('/.php/', '', $_GET['url']));
        }
        $this->url = $url;
    }
   
}

?>
