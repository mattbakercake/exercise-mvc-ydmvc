<?php

//This is the default controller

class Index_Controller extends Controller {
    
    public function index() {
        //model sets page title for view (could be from DB) and data to pass
        $this->_view->load();//dispatch index.html for this action
    }
    
    public function dbfetch() {
        //dispatch view 'listusers.html' that model has injected data to
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
