<?php

//This is the default controller

class Index_Controller extends Controller {
    
    public function index() {
        $this->view->title = "Welcome to the Framework";
        $this->view->setData('remoteAddress', $_SERVER['REMOTE_ADDR']);
        $this->view->load();
    }
    
    public function dbfetch() {
        if(!empty($this->urlValues[0]) && is_numeric($this->urlValues[0])) {
            $userData = $this->model->getUidUserDetails($this->urlValues[0]);
        } else {
            $userData = $this->model->getAllUserDetails();
        }
        $fruits = $this->model->getAllFruit();
        $this->view->title = "Show/Add Users";
        $this->view->setData('userData', $userData);
        $this->view->setData('fruits', $fruits);
        $this->view->load('listusers.html');
    }
    
    public function adduser() {
        $userData = $_POST;
        $result = $this->model->addUserDetails($userData);
        return $result;      
    }
    
    public function updateUserTable() {
        $userData = $this->model->getAllUserDetails();
        echo $this->view->partial('dblist.html',$userData);
    }

}
?>
