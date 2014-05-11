<?php
/**
 * The Home_Controller class services requests from demo home page.
 * 
 * @category Controllers
 * @version 0.2
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
class Home_Controller extends Controller {
    
    /**
     * Controller action for requests to /home/index
     * Public function launches the Home model index() function
     * 
     */
    public function index() {
        $this->_model->index(); //calls model function
    }
    
     /**
     * Controller action for requests to /home/dbfetch 
     * Public function sets an html title for view, checks for
     * a parameter in the url and launches the dbfetch function in the model
     * to display a list of users 
     * 
     */
    public function dbfetch() {
        $this->_view->title = "Show/Add Users";//set HTML title for view
        
        //get parameter passed from URL
        if (isset($this->_params[0])) {
            $param = (int)$this->_params[0];
        }
        
        $this->_model->dbfetch($param); //call dbfetch method from model
    }
    
    /**
     * Controller action for requests to /home/adduser 
     * Public function grabs POST data and sends it to the model method to add
     * a new user record returning the status result
     * 
     * Called by AJAX function submitUserForm() in script.js
     * 
     */
    public function adduser() {
        $userData = $_POST;

        $result = $this->_model->saveuser($userData); //call model method
        return $result; //return result to calling function
    }
    
    /**
     * Controller action for requests to /home/deleteuser 
     * Public function looks for a parameter in the url and calls
     * model method with it to delete a user record.
     */
    public function deleteuser() {
        if (isset($this->_params[0])) { //if param set
            $this->_model->deleteuser($this->_params[0]); //call model method
        }
    }
    
    /**
     * Controller action for requests to /home/updateusertable
     * Public function calls model method to redraw table of users
     * 
     * Called by AJAX functions submitUserForm() and deleteuser() in script.js
     */
    public function updateusertable() {
        $this->_model->updateusertable(); //call model method
    }

}
?>
