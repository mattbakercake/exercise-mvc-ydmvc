<?php

//This is the base model class - all models must be extended from it
/**
 * The Model class is a base class from which all new models
 * must extend.
 * 
 * It contains methods and properties common to all models
 * 
 * @category Core
 * @version 0.1
 * @since 26-02-2013
 * @author Matt Baker <dev@mikesierra.net>
 */
class Model {

    /**
     * Instance of database handle object
     * @var Object 
     */
    protected $dbHandle;
    /**
     * String containing SQL statement to be executed
     * @var String
     */
    protected $sql;
    /**
     * String containing any error messages
     * @var String
     */
    public $errorInfo;
    
    /**
     * Constructor currently does nothing
     */
    function __construct() {
        
    }
    
   /**
    * Protected function that sets a database handle object for the
    * model or throws an exception 
    * @global String $dsn
    */
    protected function initDB() {
        global $dsn; //set in settings.inc.php
        try {
            $this->dbHandle = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Database Connection Error: ' . $e->getMessage());
           
        }
    }
    
    /**
     * protected function that releases database handle
     */
    protected function quitDB() {
        $this->dbHandle = NULL;
    }
    
    /**
     * Protected function that sets model object property with sql
     * string to be executed
     * @param String $sql
     */
    protected function setSql($sql) {
        $this->sql = $sql;
    }
    
    /**
     * Protected function that fetches and returns database rows matching
     * sql query
     * 
     * @example
     *  ##from model##<br/>
     *  $this->setSql($sql); ##$sql contains sql string to be executed##<br/>
     *  $data = $this->getAll();<br/>
     *
     * @return Array
     * @throws Exception
     */
    protected function getAll() {
        $this->initDB();
        if (!$this->sql) {
            throw new Exception(" No SQL query passed to getAll()! ");
        }
        $query = $this->dbHandle->prepare($this->sql);
        $query->execute();
        return $query->fetchAll();
        $this->quitDB();
    }
    
    /**
     * Protected function that inserts array of user data into prepared
     * statement to prevent SQL injection and executes sql, returning 
     * result as boolean and storing any error message or throwing exception
     * if no sql has been provided
     * 
     * @example
     *  ##in model##<br/>
     *  $sql = "INSERT INTO User(firstname,surname,fruit)VALUES(:firstname,:surname,:fruit)";<br/>
     *  $userData = array('firstname'=>'Joe','surname'=>'Bloggs','fruit'=>'Apple'); ##e.g. from form submission##<br/>
     *  $this->setSql($sql);<br/>
     *  $result = $this->insertAll($userData);<br/>
     * 
     * @param Array $userData
     * @return Boolean
     * @throws Exception
     */
    protected function insertAll($userData) {
        $userData = $this->keysToPlaceholders($userData);
        $this->initDB();
        if (!$this->sql) {
            throw new Exception(" No SQL query passed to insertAll()! ");
        }
        $query = $this->dbHandle->prepare($this->sql);
        try {
            $result = $query->execute($userData);
            $this->errorInfo = $this->dbHandle->errorInfo();
            return $result;
        } catch(PDOException $e) {
            print "Error inserting data into database: " . $e->getMessage();
        }
    }
    
    /**
     * Private function modifies associative array of values so that key
     * values are prefixed ':' (e.g. ':name'), and returns the array so
     * that it can be used to insert values into prepared statement
     * 
     * @param Array $assocArray
     * @return Array
     */
    private function keysToPlaceholders($assocArray) {
        $convertedArray = array();
        foreach ($assocArray as $key => $value) {
           $convertedArray[':'.$key] = $value;
        }
        return $convertedArray;
    }
    
    
    

}
?>
