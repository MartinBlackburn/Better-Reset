<?php

class UpdateProperties 
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
    *
    * @return int $elementID
    */
    public function saveElement($elementName)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //check if element already exists
        $sql = "SELECT ID FROM Elements WHERE Name = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($elementName));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$result) {
            //element doesnt exist, save it and return its ID
            $sql = "INSERT INTO Elements (Name) VALUES (?)";
            $query = $connection->prepare($sql);
            $query->execute(array($elementName));
    
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
    */
    public function saveProperty($propertyName, $propertyValue, $elementID, $browserID)
    {
        /* @var $connection PDO */
        $connection = $this->connection;
        
        //check if property already exists
        $sql = "SELECT ID FROM Properties WHERE Name = ? AND Value = ? AND ElementID = ? AND BrowserID = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($propertyName, $propertyValue, $elementID, $browserID));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$result) {
            //property doesnt exist, save it
            $sql = "INSERT INTO Properties (Name, Value, ElementID, BrowserID) VALUES (?)";
            $query = $connection->prepare($sql);
            $query->execute(array($elementName));
    
            $elementID = $connection->lastInsertId();
        }
    }
}