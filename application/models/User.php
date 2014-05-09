<?php
/**
 * The User class extends the abstract model class
 * it holds properties and methods for user objects.
 * 
 * @category Models
 * @version 0.1
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
class User extends Model {
    
    /**
     * Integer containing unique id of the user
     * @var int 
     */
    protected $id;
    /**
     * String containing firstname of the user
     * @var string 
     */
    protected $firstname;
     /**
     * String containing surname of the user
     * @var string 
     */
    protected $surname;
    /**
     * Integer containing unique id of user's favourite fruit
     * @var int 
     */
    protected $fruit;
    
    /**
     * Public function sets user id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Public function gets user id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Public function sets user firstname
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
    
    /**
     * Public function gets user firstname
     */
    public function getFirstname() {
        return $this->firstname;
    }
    
    /**
     * Public function sets user surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }
    
    /**
     * Public function gets user surname
     */
    public function getSurname() {
        return $this->surname;
    }
    
    /**
     * Public function sets user's favourite fruit
     */
    public function setFruit($fruit) {
        $this->fruit = $fruit;
    }
    
    /**
     * Public function gets user's favourite fruit
     */
    public function getFruit() {
        return $this->fruit;
    }
   
    /**
     * Public function sets user properties by matching id
     * 
     * @example
     * $user = new User();<br/>
     * $user->findById(7);
     */
    public function findById($id) {
        $result =  $this->_repository->findById($id);
        if ($result){
            $this->setId($result['id']);
            $this->setFirstname($result['firstname']);
            $this->setSurname($result['surname']);
            $this->setFruit($result['fruit']);
        }
    }
    
    /**
     * Public function returns list of all users' properties
     * 
     * @return array
     * 
     * @example
     * $user = new User();<br/>
     * $result = $user->findAll();
     */
    public function findAll() {      
        return $this->_repository->findAll();
    }
    
    /**
     * Public function creates new user record from object
     * 
     * @example
     * $user->create();<br/>
     */
    public function create() {
        $params = array(array(
           'firstname' => $this->getFirstname(),
           'surname' => $this->getSurname(),
           'fruit' => $this->getFruit()
        ));
        
        $result = $this->_repository->create($params);
        
        return $result;
    }
    
    /**
     * Public function deletes user record
     * 
     * @example
     * $user = new User();<br/>
     * $user->findById(7);
     * $user->destroy();
     */
    public function destroy() {
        $result = $this->_repository->destroy($this->getId());
        
        return $result;
    }

    
}
