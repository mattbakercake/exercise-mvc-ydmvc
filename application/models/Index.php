<?php
//This is the default model

class Index extends Model{
    
    public function getAllUserDetails() {
        $sql = "Select
                  u.id,
                  u.firstname,
                  u.surname,
                  f.name
                From
                  User u
                INNER JOIN
                  Fruit AS f on u.fruit = f.id
                ORDER BY u.id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();
        
        if (empty($data)) {
            return false;
        }
        
        return $data;
    }
    
    public function getUidUserDetails($uid) {
        $sql = "Select
                  u.id,
                  u.firstname,
                  u.surname,
                  f.name
                From
                  User u
                INNER JOIN
                  Fruit AS f on u.fruit = f.id 
                WHERE u.id = ".$uid." 
                ORDER BY u.id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();       
        if (empty($data)) {
            return false;
        }
        return $data;
    }
    
    public function getAllFruit() {
        $sql = "Select
                  id,
                  name
                From
                  Fruit
                ORDER BY id ASC";
        
        $this->_setSql($sql);
        $data = $this->_getAll();       
        if (empty($data)) {
            return false;
        }
        return $data;
    }
    
    public function addUserDetails($userData) {
        unset($userData['submit']);
 
        $sql = "INSERT INTO User 
                (firstname,
                surname,fruit) 
                VALUES 
                (:firstname,
                :surname,:fruit)";
        
        $this->_setSql($sql);
        $result = $this->_insertAll($userData);
        return $result;
    }

}
?>
