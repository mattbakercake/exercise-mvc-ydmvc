<?php

/**
 * Description of Fruit_Repository
 *
 * @author Matt
 */
class Fruit_Repository {
    
    protected $db;
    
    function __construct() {
        if (!is_object($this->db)) {
            $this->db = new DB();
        }
    }
    
     public function findAll(){
        $this->db->initDB();
        $sql = "SELECT * FROM fruit";
        $query = $this->db->_dbHandle->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $this->db->quitDB();
        return $result;
     }
     
    public function findById($id) {
        $this->db->initDB();
        $sql = "SELECT * FROM fruit WHERE id=" . $id;
        $query = $this->db->_dbHandle->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        $this->db->quitDB();
        return $result;
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function destroy() {
        
    }
    
}
