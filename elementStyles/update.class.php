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
     * @return int $browserId
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
            
            $browserId = $connection->lastInsertId();
        } else {
            //browser exists, return its ID
            $browserId = $result["ID"];
        }
        
        return $browserId;
    }
    
    
    /**
    * Save element to database
    *
    * @param string $elementName
    *
    * @return int $elementId
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
    
            $elementId = $connection->lastInsertId();
        } else {
            //browser exists, return its ID
            $elementId = $result["ID"];
        }
    
        return $elementId;
    }
}