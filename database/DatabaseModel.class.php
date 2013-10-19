<?php

class DatabaseModel 
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
    
    
    /**
     * Save browser details to database
     * 
     * @param string $browserName
     * @param string $browserVersion
     * 
     * @return int $browserID
     */
    public function saveBrowser($browserName, $browserVersion)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //trim whitespace
        $browserName = trim($browserName);
        $browserVersion = trim($browserVersion);
        
        //check if browser already exists
        $sql = "SELECT ID FROM Browsers WHERE Name = ? AND Version = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($browserName, $browserVersion));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$result) {
            //browser doesnt exist, save it and return its ID
            $sql = "INSERT INTO Browsers (Name, Version) VALUES (?, ?)";
            $query = $connection->prepare($sql);
            $query->execute(array($browserName, $browserVersion));
            
            $browserID = $connection->lastInsertId();
        } else {
            //browser exists, return its ID
            $browserID = $result["ID"];
        }
        
        return $browserID;
    }
    
    
    /**
    * Save element to database
    *
    * @param string $elementName
    * @param string $elementType
    *
    * @return int $elementID
    */
    public function saveElement($elementName, $elementType)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //trim whitespace
        $elementName = trim($elementName);
        $elementType = trim($elementType);
        
        //check if element already exists
        $sql = "SELECT ID FROM Elements WHERE Name = ? AND Type = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($elementName, $elementType));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$result) {
            //element doesnt exist, save it and return its ID
            $sql = "INSERT INTO Elements (Name, Type) VALUES (?, ?)";
            $query = $connection->prepare($sql);
            $query->execute(array($elementName, $elementType));
    
            $elementID = $connection->lastInsertId();
        } else {
            //browser exists, return its ID
            $elementID = $result["ID"];
        }
    
        return $elementID;
    }
    
    
    /**
    * Save property to database
    *
    * @param string $propertyName
    * @param string $propertyValue
    * @param int $elementID
    * @param int $browserID
    * 
    * @return int $propertyID
    */
    public function saveProperty($propertyName, $propertyValue, $elementID, $browserID)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //trim whitespace
        $propertyName = trim($propertyName);
        $propertyValue = trim($propertyValue);
        
        //check if property already exists
        $sql = "SELECT ID FROM Properties WHERE Name = ? AND Value = ? AND ElementID = ? AND BrowserID = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($propertyName, $propertyValue, $elementID, $browserID));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$result) {
            //property doesnt exist, save it
            $sql = "INSERT INTO Properties (Name, Value, ElementID, BrowserID) VALUES (?, ?, ?, ?)";
            $query = $connection->prepare($sql);
            $query->execute(array($propertyName, $propertyValue, $elementID, $browserID));
    
            $propertyID = $connection->lastInsertId();
        } else {
            //browser exists, return its ID
            $propertyID = $result["ID"];
        }
        
        return $propertyID;
    }
}