<?php
/**
 * DB class creates/destroys db specific connection handle
 * @author Matt
 */
class DB {
    
    public $_dbHandle;
    
    /**
    * Protected function that sets a database handle object for the
    * model or throws an exception 
    * @global String $dsn
    */
    public function initDB() {
        global $dsn; //set in settings.inc.php
        try {
            $this->_dbHandle = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Database Connection Error: ' . $e->getMessage());
           
        }
    }
    
    /**
     * protected function that releases database handle
     */
    public function quitDB() {
        $this->_dbHandle = NULL;
    }
    
}
