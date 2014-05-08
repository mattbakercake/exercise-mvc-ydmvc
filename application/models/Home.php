
<?php

/**
 * Index_Model extents the abstract Model class. It contains model methods/actions
 */
class Home extends Model{
    
  
    public function index() {
         //set HTML title for view
         $this->_view->title = "Welcome to the Framework";
         //add variable $remoteAddress to view containing caller's ip address
         $this->_view->setData('remotePort', filter_var($_SERVER['REMOTE_PORT'], FILTER_VALIDATE_INT)); 
         
         $user = new User;
         $user->findById(8);
         echo $user->getFirstname() . " " . $user->getSurname();
    }
    
    public function dbfetch($param = NULL) {   
        //check for paramter passed from url->controller and perform appropriate action
        if(!empty($param) && is_int($param) ) {
            $this->_view->setData('heading', 'List Single User');
            $user = new User;
            $user->findById($param);
            
            $fruit = new Fruit();
            $fruit->findById($user->getFruit());
            
            $userData = array(array(
                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'surname' => $user->getSurname(),
                'fruit' => $fruit->getName()
            ));
        } else {
            $this->_view->setData('heading', 'List All Users');
            $user = new User();
            $userData = $user->findAll();

            for ($i=0; $i < count($userData); $i++) {
                $fruit = new Fruit();
                $fruit->findById($userData[$i]['fruit']);
                $userData[$i]['fruit'] = $fruit->getName();
            }
        }
        //get array of fruits from database
        $fruit = new fruit();
        $fruits = $fruit->findAll();
        
        //add $userData array and $fruits array to view
        $this->_view->setData('userData', $userData);
        $this->_view->setData('fruits', $fruits);
    }
    
    public function saveuser($data) {
       $user = new User();
       
       $user->setFirstname(filter_var($data['firstname'], FILTER_SANITIZE_STRING));
       $user->setSurname(filter_var($data['surname'], FILTER_SANITIZE_STRING));
       $user->setFruit($data['fruit']);
       
       if ($user->getFirstname() != '' && $user->getSurname() != '' && $user->getFruit() != '') {
           $user->create();
       } else {
          echo "Complete All Fields";
       }
    }
}
?>
