
<?php

/**
 * Index_Model extents the abstract Model class. It contains model methods/actions
 */
class Index_Model extends Model{
    
  
    public function index() {
         //set HTML title for view
         $this->_view->title = "Welcome to the Framework";
         //add variable $remoteAddress to view containing caller's ip address
         $this->_view->setData('remoteAddress', $_SERVER['REMOTE_ADDR']);
    }
    
    public function dbfetch($param = NULL) {   
        //check for paramter passed from url->controller and perform appropriate action
        if(!empty($param) && is_numeric($param) ) {
            $this->_view->setData('heading', 'List Single User');
            $userData = $this->getUidUserDetails($param);
        } else {
            $this->_view->setData('heading', 'List All Users');
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
