
<?php
/**
 * The Home class extends the abstract model class 
 * it holds properties and methods for the home model
 * 
 * @category Models
 * @version 0.2
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
class Home extends Model{
    
     /**
     * Public function sets a view title, sends data to the view and loads it
     *
     */
    public function index() {  
         $this->_view->title = "Welcome to the Framework";//set HTML title for view
         
         $this->_view->setData( //add variable to view containing requesting port
                    'remotePort', 
                    filter_var($_SERVER['REMOTE_PORT'], FILTER_VALIDATE_INT)
                );
         
         $this->_view->load(); //load the view
    }
    
     /**
     * Public function sets a view title, compiles data depending on whether
     * parameters passed and sends data to view before loading it
     *
     */
    public function dbfetch($param = NULL) { 
       $user = new User(); //instantiate new User object
       $fruit = new Fruit(); //instantiate new fruit object
       
        if(!empty($param) && is_int($param) ) { //if INT from url->controller
            $this->_view->setData('heading', 'List Single User'); //send data to view
            
            //find user by id passed to function
            $user->findById($param);
            
            //get fruit properties by id
            $fruit->findById($user->getFruit());
            
            $userData = array(array( //create array of user data
                'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'surname' => $user->getSurname(),
                'fruit' => $fruit->getName() //substitute fruit id for name
            ));
        } else { //INT NOT passed by controller
            $this->_view->setData('heading', 'List All Users'); //send data to view
            
            //get list of all users
            $userData = $user->findAll();

            //rewrite array, swap fruit id for name
            for ($i=0; $i < count($userData); $i++) {
                $fruit->findById($userData[$i]['fruit']);
                $userData[$i]['fruit'] = $fruit->getName();
            }
        }
        
        //add $userData array and $fruits array to view
        $this->_view->setData('userData', $userData);
        $this->_view->setData('fruits', $fruit->findAll());
        
        $this->_view->load('listusers.html');//load view
    }
    
    /**
     * Public function checks user form completed and adds new user record
     * 
     * Called by AJAX function submitUserForm() via controller
     *
     */
    public function saveuser($data) {
       $user = new User(); //instantiate new user object
       
       //set user properties with form data, using filters to sanitize user input
       $user->setFirstname(filter_var($data['firstname'], FILTER_SANITIZE_STRING));
       $user->setSurname(filter_var($data['surname'], FILTER_SANITIZE_STRING));
       $user->setFruit($data['fruit']);
      
       if ($user->getFirstname() != '' && $user->getSurname() != '' && $user->getFruit() != '') {
           $success = $user->create(); //if all properties set create user
       } else {
          $success = false; // return false if properties not set
       }
       
       //return JSON encoded object back to AJAX declaring status(true/false) and message
       if ($success) {
           echo '{"status" : "1", "msg" : "User Added Successfully"}';
       } else {
           echo '{"status" : "0", "msg" : "There was a problem adding user"}';
       }
       
    }
    
    /**
     * Public function deletes user record
     * 
     * Called by AJAX function deleteuser() via controller
     *
     */
    public function deleteuser($id) {
        $user = new User(); //instantiate user object
        $user->findById($id); //set user
        
        $success = $user->destroy(); //delete user
        
        //return JSON encoded object back to AJAX declaring status(true/false) and message
        if ($success) {
           echo '{"status" : "1", "msg" : "User Deleted Successfully"}';
       } else {
           echo '{"status" : "0", "msg" : "There was a problem deleting user"}';
       }
    }
    
    /**
     * Called by controller action
     * Public function finds all users from data source and sends the 
     * data to the view partial dblist.html
     * 
     * Called by AJAX function submitUserForm() in script.js
     * 
     */
    public function updateusertable() {
        $users = new User(); //instantiate user object
        $fruit = new Fruit(); //instantiate fruit object
        
        $userData = $users->findAll(); //array of all users
            
            //rewrite user array - swap fruit id for fruit names
            for ($i=0; $i < count($userData); $i++) {
                $fruit->findById($userData[$i]['fruit']);
                $userData[$i]['fruit'] = $fruit->getName();
            }
        
        //send data back to view partial dblist.html via calling AJAX function    
        echo $this->_view->partial('dblist.html',$userData);
    }
}
?>
