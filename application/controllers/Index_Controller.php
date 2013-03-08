<?php

//This is the default controller

class Index_Controller extends Controller {
    
    public function index() {
        $this->_view->title = "Welcome to the Framework";
        $this->_view->setData('remoteAddress', $_SERVER['REMOTE_ADDR']);
        $this->_view->load();
    }
    
    public function dbfetch() {
        if(!empty($this->_urlValues[0]) && is_numeric($this->_urlValues[0])) {
            $userData = $this->_model->getUidUserDetails($this->_urlValues[0]);
        } else {
            $userData = $this->_model->getAllUserDetails();
        }
        $fruits = $this->_model->getAllFruit();
        $this->_view->title = "Show/Add Users";
        $this->_view->setData('userData', $userData);
        $this->_view->setData('fruits', $fruits);
        $this->_view->load('listusers.html');
    }
    
    public function adduser() {
        $userData = $_POST;
        $result = $this->_model->addUserDetails($userData);
        return $result;      
    }
    
    public function updateUserTable() {
        $userData = $this->_model->getAllUserDetails();
        echo $this->_view->partial('dblist.html',$userData);
    }

}
?>
