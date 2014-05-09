<?php
/**
 * The Fruit class extends the abstract model class
 * it holds properties and methods for fruit objects.
 * 
 * @category Models
 * @version 0.1
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
class Fruit extends Model {
    
     /**
     * Integer containing unique id of the fruit
     * @var int 
     */
    protected $id;
     /**
     * String containing name of the fruit
     * @var string 
     */
    protected $name;
    
    
     /**
     * Public function sets fruit id
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * Public function gets fruit id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Public function sets fruit name
     */
    public function setName($name) {
        $this->name = $name;
    }
    
    /**
     * Public function gets fruit name
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Public function returns list of all fruits' properties
     * 
     * @return array
     * 
     * @example
     * $fruits = new Fruit();<br/>
     * $result = $fruits->findAll();
     */
    public function findAll() {
        $result = $this->_repository->findAll();
        return $result;
    }
    
     /**
     * Public function sets fruit object properties for matching id
     * 
     * @example
     * $fruit = new Fruit();<br/>
     * $fruit->findById(3);<br />
     * echo $fruit->getId();<br />
     * echo $fruit->getName();
     */
    public function findById($id) {
        $result = $this->_repository->findById($id); //fetch matching record
        $this->setId($result['id']); //set object id property
        $this->setName($result['name']); //set object name property
        
    }
}
