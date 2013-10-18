<?php

class GenerateTables 
{
    //configuration
    private $dbhost = "localhost";
    private $dbname = "betterReset";
    private $dbuser = "betterReset";
    private $dbpass = "4etHNNxd";
    
    //database connection
    private $connection = null;
    
    function __construct()
    {
        $this->connection = new PDO("mysql:host=$this->dbhost; dbname=$this->dbname", $this->dbuser, $this->dbpass);
    }
    
    
    /**
    * Get all browsers from database
    *
    * @return array $browsers
    */
    public function getBrowsers()
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        $sql = "SELECT * FROM Browsers";
        $query = $connection->prepare($sql);
        $query->execute();
        $browsers = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $browsers;
    }
    
    
    /**
     * Get all elements from database
     * 
     * @return array $elements
     */
    public function getElements()
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        $sql = "SELECT * FROM Elements";
        $query = $connection->prepare($sql);
        $query->execute();
        $elements = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $elements;
    }
    
    
    /**
    * Get all styles for an element/browser
    *
    * @return array $properties
    */
    public function getStyles($elementID, $browserID)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //check if browser already exists
        $sql = "SELECT * FROM Properties WHERE ElementID = ? AND BrowserID = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($elementID, $browserID));
        $properties = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $properties;
    }
}



$generateTables = new GenerateTables();