<?php

/**
 * Description of User
 *
 * @author Matt
 */
class User extends Model {
    
    protected $id;
    protected $firstname;
    protected $surname;
    protected $fruit;
    
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function setSurname($surname) {
        $this->surname = $surname;
    }
    
    public function getSurname() {
        return $this->surname;
    }
    
    public function setFruit($fruit) {
        $this->fruit = $fruit;
    }
    
    public function getFruit() {
        return $this->fruit;
    }
   
    public function findById($id) {
        $result =  $this->_repository->findById($id);
        if ($result){
            $this->setId($result['id']);
            $this->setFirstname($result['firstname']);
            $this->setSurname($result['surname']);
            $this->setFruit($result['fruit']);
        }
    }
    
    public function findAll() {      
        return $this->_repository->findAll();
    }
    
    public function create() {
        $params = array(array(
           'firstname' => $this->getFirstname(),
           'surname' => $this->getSurname(),
           'fruit' => $this->getFruit()
        ));
        
        $result = $this->_repository->create($params);
        
        return $result;
    }
    
    public function destroy() {
        $result = $this->_repository->destroy($this->getId());
        
        return $result;
    }

    
}
