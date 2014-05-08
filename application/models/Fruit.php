<?php
/**
 * Description of Fruit
 *
 * @author Matt
 */
class Fruit extends Model {
    
    protected $id;
    protected $name;
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function findAll() {
        $result = $this->_repository->findAll();
        return $result;
    }
    
    public function findById($id) {
        $result = $this->_repository->findById($id);
        $this->setId($result['id']);
        $this->setName($result['name']);
        
    }
}
