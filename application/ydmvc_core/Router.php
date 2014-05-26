<?php
/**
 * The Router class serves stored routes and parameters or parses the url to 
 * extract the controller,action and any parameters being requested
 *
 * @version 0.1
 * @since 26-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 * 
 */
class Router {
    
    /**
     * declared custom routes
     * @var array
     */  
    private $_routes = array();
    /**
     * the request uri
     * @var string
     */  
    private $_requesturi;
    /**
     * array of uri elements
     * @var array
     */  
    private $_realBits;
    /**
     * array of stored uri elements
     * @var array
     */  
    private $_routeBits;
    /**
     * controller name
     * @var string
     */  
    public $controller = DEFAULT_CONTROLLER;
    /**
     * action name
     * @var string
     */  
    public $action = DEFAULT_ACTION;
    /**
     * parameters
     * @var array
     */  
    public $params = array();
    
    /**
     * Constructor grabs defined routes from routes.php, stores the request
     * URI and then determines whether the current request matches a stored route.
     * Controller/action and params are passed back to the front controller
     */
    public function __construct() {
        try { //if routes.php exists/is valid then include
            include(DOCUMENT_ROOT.'/application/routes.php');
        } catch (Exception $e) {
            echo 'routes.php error: ' . $e->getMessage();
        }
        
        $this->_setRequestUri(); //extract and store the request uri
        $this->_getRoute(); //serve route back to front controller
        
    }
    
    /**
     * Builds a complete request URL and then determines the URI by removing
     * the framework's decared base url.  The full request URI and an array of
     * URI elements are stored in the Router object
     */
    private function _setRequestUri() {
        $s = ($_SERVER["HTTPS"] == "on") ? "s" : ""; //detect whether https protocol
        
        //full url
        $thisurl = trim(htmlentities("http" . $s . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]));
        //remove base url to leave application URI
        $requesturi = preg_replace('!'.BASE_URL.'!','', $thisurl);
                
        $this->_requesturi = ltrim($requesturi,'/'); //store full URI
        $this->_realBits = explode('/', ltrim($this->_requesturi,'/'));//break full URI to components
    }
    
    /**
     * Stores route declaration in array
     */
    public function setRoutes($data) {
        array_push($this->_routes, $data); //pushes array of route data to object
    }

    /**
     * Adds a stored route to the router object.  Accepts three parameters: $uri 
     * is a URI string that can contain placeholders (with leading ':') that 
     * represent parameter values.  $route is an associative array containing 3 
     * values (controller - string, action - string, params - array of parameter
     * values). $filter is an optional array containing associative key=>value
     * pairs that match placeholder names to regex filters for values to be 
     * checked against.
     * 
     * @param string $uri
     * @param array $route
     * @param array $filters
     * 
     *  @example
     *  $this->addRoute('/showuser/:1/:string',<br/>
     *        array(<br/>
     *              'controller'=>'home',<br/>
     *              'action'=>'dbfetch',<br/>
     *              'params'=>array(2)<br/>
     *          ),<br/>
     *          array(<br/>
     *              '1'=>'/^[0-9]+$/',<br/>
     *              'string'=>'/^string$/'<br/>
     *          ));<br/>
     */
    public function addRoute($uri=NULL, $route=NULL, $filters=NULL) {
        if (!IS_NULL($uri) && !IS_NULL($route)) {  //check uri and route values are set
            if (key_exists('controller', $route) && key_exists('action', $route)) { //check controller/action set
                $data = array(//set all request values into a single array
                    'url'=>$uri,
                    'controller'=>$route['controller'],
                    'action'=>$route['action'],
                    'filters'=>$filters
                );
            }
            $data['params'] = (key_exists('params', $route)? $route['params']: NULL); //add params to data if exist
            
            $this->setRoutes($data); //store route data in router object
        }
    }
    
    /**
     * Checks current request URI against stored routes, setting applicable
     * controller/action/params
     */
    private function _getRoute() {
        
        $storedroute = FALSE;
        
        foreach ($this->_routes as $route) { //for each stored route
            $result = $this->_decodeURI($route); //replace any placeholders and check validity
            if ($result) { //if stored route matches URI
                $storedroute = TRUE;  //set flag
            }
        }
        
        if (!$storedroute) { //URI doesn't match stored route
            $this->_request(); //decode route from uri
        }
        
    }
    
    /**
     * Determines whether request URI has a valid match to a stored route, and sets
     * controller/action and parameter values of router object
     *  
     * @param array $route
     * @return boolean
     */
    private function _decodeURI($route) {
        
        $result = FALSE;
        
        $samelength = $this->_routeLength($route);
        
        if ($samelength){ //Num elements in route and uri match
            if ($this->_routePlaceholders($route)) { //any placeholders successfully substituted
                $routeuri = implode('/', $this->_routeBits);
                if ($routeuri == $this->_requesturi) { //route matches request
                    $this->controller = $route['controller'];
                    $this->action = $route['action'];
                    if (empty($this->params) && !empty($route['params'])) {  //set params
                        $this->params = $route['params'];
                    }
                    $result = TRUE;
                }
            }
        }
  
        return $result;
            
    }
    
    
    /**
     * Determines whether the length of actual URI and stored URI matches.
     * accepts $route array containing 'url' key, returns a boolean.
     * 
     * @param array $route
     * @return boolean
     */
    private function _routeLength($route) {
        $this->_routeBits = explode('/', ltrim($route['url'],'/'));//break route uri to components
        
        if (count($this->_routeBits) == count($this->_realBits)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Parses stored route URI,finds any placeholders (e.g. :value), checks placeholder
     * values against filters (if exist), stores values in the route array and returns 
     * a status flag to indicate whether route is valid.
     * 
     * @param array $route
     * @return boolean
     */
    private function _routePlaceholders($route) {
        $result = TRUE;
        
        $filters = $route['filters'];
        
        foreach ($this->_routeBits as $key => $value) { //go through stored uri structure
            if (preg_match('/^:([\w]+)/', $value, $matches)) { //if uri component is a placeholder
                if (array_key_exists($matches[1], $filters)) { //if a  filter exists
                    if (preg_match($filters[$matches[1]], $this->_realBits[$key])) { //value conforms to filter regex
                        $this->_routeBits[$key] = $this->_realBits[$key]; //replace the placeholder with value
                    } else {
                        $result = FALSE; //regex filter fails
                    }
                } else {//no filter
                    $this->_routeBits[$key] = $this->_realBits[$key]; //no filters so set placeholder to corresponding uri value
                }
                
                if (empty($route['params'])) { //if params not specified in route
                    array_push($this->params,$this->_realBits[$key]);//push uri value of placeholder to params array
                }
            }
        }
        
        
        return $result;
    }
    
    /**
     * private function extracts controller,action and parameters
     * from uri
     */
    private function _request() {
        $parameters = explode("/", $this->_requesturi);//split uri into array
        
        //check array key for value - set class 
        //property and remove from array
        if (!empty($parameters[0])) {
           $this->controller = array_shift($parameters); 
        }
        
        if (!empty($parameters[0])) {
           $this->action = array_shift($parameters); 
        }
        
         if (!empty($parameters)) {
           $this->params = $parameters; 
        }
    }
    
}


