<?php

/**
 * Index_Model extents the abstract Model class. It contains model methods/actions
 */
class Index_Model extends Model{
    
    /**
     * __contructor type function. The index function is the default 
     * method/action for the index controller and
     * action.  If defined, it will be executed when the index controller and action
     * are dispatched  
     */
    public function index() {
        //set HTML title for view
         $this->_view->title = "Welcome to the Framework";
         //add variable $remoteAddress to view containing caller's ip address
         $this->_view->setData('remoteAddress', $_SERVER['REMOTE_ADDR']);
    }
    
    public function dbfetch() {
        //set HTML title for view
        $this->_view->title = "Show/Add Users";
        //get parameter passed from controller
        $param = $this->_controller->_params[0];
        //check for paramter passed from url->controller->model and perform appropriate action
        if(!empty($param) && is_numeric($param) ) {
            $userData = $this->getUidUserDetails($param);
        } else {
            $userData = $this->getAllUserDetails();
        }
        //get array of fruits from database
        $fruits = $this->getAllFruit();
        
        //add $userData array and $fruits array to view
        $this->_view->setData('userData', $userData);
        $this->_view->setData('fruits', $fruits);
    }
    
    public function getAllUserDetails() {
        $sql = "Select
                  u.id,
                  u.firstname,
                  u.surname,
                  f.name
                From
                  User u
                INNER JOIN
                  Fruit AS f on u.fruit = f.id
                ORDER BY u.id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();
        
        if (empty($data)) {
            return false;
        }
        
        return $data;
    }
    
    public function getUidUserDetails($uid) {
        $sql = "Select
                  u.id,
                  u.firstname,
                  u.surname,
                  f.name
                From
                  User u
                INNER JOIN
                  Fruit AS f on u.fruit = f.id 
                WHERE u.id = ".$uid." 
                ORDER BY u.id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();       
        if (empty($data)) {
            return false;
        }
        return $data;
    }
    
    public function getAllFruit() {
        $sql = "Select
                  id,
                  name
                From
                  Fruit
                ORDER BY id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();       
        if (empty($data)) {
            return false;
        }
        return $data;
    }
    
    public function addUserDetails($userData) {
        unset($userData['submit']);
 
        $sql = "INSERT INTO User 
                (firstname,
                surname,fruit) 
                VALUES 
                (:firstname,
                :surname,:fruit)";
        
        $this->_setSql($sql);
        $result = $this->_insertAll($userData);
        return $result;
    }

}
?>
