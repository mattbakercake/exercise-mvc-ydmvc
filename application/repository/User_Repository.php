<?php
/**
 * The User_Repository class implements the Repository_Interface interface
 * it holds properties that abstract data access methods away from the model
 * 
 * @category Repository
 * @version 0.1
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
class User_Repository implements Repository_Interface{
    
    /**
     * Database object
     * @var DB Object
     */
    protected $db;
    
    /**
     * constructor instantiates DB object if it doesn't exist
     */
    function __construct() {
        if (!is_object($this->db)) {
            $this->db = new DB();
        }
    }
    
    /**
     * Public function select all Users from the database
     * 
     * @return array/assoc array
     */
    public function findAll(){
        try {
            $this->db->initDB();
            $sql = "SELECT * FROM user";
            $query = $this->db->_dbHandle->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $this->db->quitDB();
        } catch (PDOException $e) {
            $result = false;
        }
        return $result;
    }
    
    /**
     * public function selects user from db that matches id
     * 
     * @param int $id
     * @return array/assoc array
     */
    public function findById($id) {
         try {
            $this->db->initDB();
            $sql = "SELECT * FROM user WHERE id=?";
            $query = $this->db->_dbHandle->prepare($sql);
            $query->bindParam(1, $id, PDO::PARAM_INT); //bind filtered value to sql
            $query->execute();
            $result =  $query->fetch();
            $this->db->quitDB();
        } catch (PDOException $e) {
            $result = false;
        }
        return $result;
    }
    
    /**
     * public function creates a new user record
     * 
     * @param array $params
     * @return bool
     */
    public function create($params) {
        try {
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
        } catch (PDOException $e) {
            $result = false;
        }
        
        return $result;
    }
    
    /**
     * public function updates an existing database record
     */
    public function update(){
        
    }
    
    /**
     * public function deletes a user record from the database
     * 
     * @param int $id
     * @return bool
     */
    public function destroy($id) {
        try {
            $this->db->initDB();
            $sql = "DELETE FROM User WHERE id=?";
            $query = $this->db->_dbHandle->prepare($sql);
            $query->bindParam(1, $id, PDO::PARAM_INT); //bind filtered val to sql
            $result = $query->execute();
            $this->db->quitDB();
        } catch (PDOException $e) {
            $result = false;
        }
        
        return $result;
    }
    
}
