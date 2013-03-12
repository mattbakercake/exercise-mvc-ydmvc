<?php
//Base view class - calls views
/**
 * The View class is a base class from which all new views
 * must extend.
 * 
 * It contains methods and properties common to all models
 * 
 * @category Core
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net>
 */
 class View {
    
    /**
     * String containing name of the view for the controller
     * @var string 
     */
    protected $_viewFolder;
    /**
     * String containing the name of the view file. Defaults to index.html
     * @var String
     */
    protected $_file = "index.html";
    /**
     * Array of arrays of data passed to the view
     * @var Array 
     */
    protected $_viewData = array();
    /**
     * String containing HTML Title for view to be displayed in browser header.
     * Set in controller or model
     * 
     * @example
     *  $this->view->title = "A Title";
     * 
     * @var String
     */
    public $title;
    
    /**
     * Contructor sets object $viewFolder property so that html files can
     * be read from the correct view folder
     * @param String $viewName
     */
    function __construct($viewName) {
        $this->_viewFolder = $viewName;
    }
    
    /**
     * Public function launches the specified view from the controller. Defaults
     * to index.html of no file specified.
     * 
     * @example
     *  $this->view->load('someview.html');
     * 
     * @param string $file
     * @throws Exception
     */
    public function load($file = NULL) {
        if (is_null($file)) {
            $this->_file = "index.html";
        } else {
            $this->_file = $file; 
        }
        $template = SERVER_ROOT . '/application/views/template.html';//view template location
        $file = SERVER_ROOT . '/application/views/' . strtolower($this->_viewFolder) . '/' . $this->_file;//view file location
        if (file_exists($template) && USE_TEMPLATE) { //if template exists and settings say use
            if (file_exists($file)) {
                extract($this->_viewData);//inject variables into view
                ob_start();//buffer view content from files
                include $template;
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
            } else {
                throw new Exception($file . ' doesn\'t exist ');
            }
        } elseif (file_exists($file)) { //if no template
            extract($this->_viewData);//inject variables into view
            ob_start();//buffer view content from file
            include $file;
            $output = ob_get_contents();
            ob_end_clean();
            echo $output;
        } else {
            throw new Exception($file . ' doesn\'t exist ');
        }
    }
    
    /**
     * Public function injects data from controller to be used in the view
     * 
     * @example
     *  $this->view->setData('fruits' => array('apple','orange','pear'));<br/>
     * 
     * @param String $key
     * @param Mixed $value
     */
    public function setData($key,$value) {
        $this->_viewData[$key] = $value;
    }
    
    /**
     * Public function allows complex view code e.g. forms or loops to be split
     * out into view partial files and included in view to simplify code and flow.
     * place file in folder called 'partials' in the Views folder. $partialData
     * can be referenced in the partial file to access data passed to it
     * 
     * @example<br/>
     *  ##in html view file##<br/>
     *  <?php echo $this->partial('partialname.html',$fruits); ?><br/>
     * 
     * @param String $filename Name of partial file
     * @param Mixed $partialData Data to be referenced in partial e.g. array or string
     * @return String A string containing the buffered output of the partial script
     * @throws Exception
     * 
     */
    public function partial($filename,$partialData) {
        $file = SERVER_ROOT . '/application/views/partials/' . $filename;
        if (file_exists($file)) {
            ob_start(); //start output buffering
            include($file); //open the partial file
            $output = ob_get_contents(); //collect the partial output
            ob_end_clean();
            return $output;
        } else {
            throw new Exception($file . ' doesn\'t exist ');
        }
    }

}
?>
