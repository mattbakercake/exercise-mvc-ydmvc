<?php
/**
 * Description of User_Repository
 *
 * @author Matt
 */
class User_Repository implements Repository_Interface{
    
     protected $db;
    
    function __construct() {
        if (!is_object($this->db)) {
            $this->db = new DB();
        }
    }
    
    public function findAll(){
        $this->db->initDB();
        $sql = "SELECT * FROM user";
        $query = $this->db->_dbHandle->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $this->db->quitDB();
        return $result;
    }
    
    public function findById($id) {
        $this->db->initDB();
        $sql = "SELECT * FROM user WHERE id=?";
        $query = $this->db->_dbHandle->prepare($sql);
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $query->execute();
        $result =  $query->fetch();
        $this->db->quitDB();
        return $result;
    }
    
    public function create($params) {
        $this->db->initDB();
        $sql = "INSERT INTO User(firstname,surname,fruit) 
                VALUES 
                (:firstname,:surname,:fruit)";
        $query = $this->db->_dbHandle->prepare($sql);
        foreach ($params as $p) {
            $query->bindParam(':firstname', $p['firstname'], PDO::PARAM_STR);
            $query->bindParam(':surname', $p['surname'], PDO::PARAM_STR);
            $query->bindParam(':fruit', $p['fruit'], PDO::PARAM_INT);
        }
        $result = $query->execute();
        $this->db->quitDB();
        
        return $result;
    }
    
    public function update(){
        
    }
    
    public function destroy($id) {
        $this->db->initDB();
        $sql = "DELETE FROM User WHERE id=?";
        $query = $this->db->_dbHandle->prepare($sql);
        $query->bindParam(1, $id, PDO::PARAM_INT);
        $result = $query->execute();
        $this->db->quitDB();
        
        return $result;
    }
    
}
