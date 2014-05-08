<?php

//This is the default controller

class Home_Controller extends Controller {
    
    public function index() {
        //call model method
        $this->_model->index();
        //model sets page title for view (could be from DB) and data to pass
        $this->_view->load();//dispatch index.html for this action
    }
    
    public function dbfetch($param = NULL) {
         //set HTML title for view
        $this->_view->title = "Show/Add Users";
        
        //get parameter passed from URL
        if (isset($this->_params[0])) {
            $param = (int)$this->_params[0];
        }
        //Call model with any parameters and dispatch view 'listusers.html'
        $this->_model->dbfetch($param);
        $this->_view->load('listusers.html');
    }
    
    public function adduser() {
        $userData = $_POST;
        $result = $this->_model->saveuser($userData);
        return $result;      
    }
    
    public function updateusertable() {
        $users = new User();
        $userData = $users->_repository->findAll();
        echo $this->_view->partial('dblist.html',$userData);
    }

}
?>