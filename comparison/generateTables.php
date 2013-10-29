<?php

include(dirname(__FILE__) . "/../database/DatabaseModel.class.php");

$databaseModel = new DatabaseModel();

//get lsit of browsers
$browsers = $databaseModel->getBrowsers();

//get list of elements
$elements = $databaseModel->getElements();

//number of columns
//+1 for the property name column
$numCols = count($browsers) + 1;

//foreach element, create a table, with a column for each browser
foreach($elements as $element)
{
	//element details
    $elementID = $element['ID'];
    $elementName = $element['Name'];
    $elementType = $element['Type'];
    
    //update with progress
	echo "##### CREATING $elementName table #####" . PHP_EOL;
    
    //create file
    $filename = $elementName;
    if($elementType) {
        $filename = $filename . '-' . $elementType;
    }
    $file = dirname(__FILE__) . '/elements/test-' . $filename . '.html';
    
    //open table
    $fileData = "<table>\n";
    $fileData .= "    <thead>\n";
    $fileData .= "        <tr>\n";
    $fileData .= "            <th>Property</th>\n";
    
    //create table headings
    foreach($browsers as $browser)
    {
        //browser details
        $browserID = $browser['ID'];
        $browserName = $browser['Name'];
        $browserVersion = $browser['Version'];
        
        //write column with browser name and version
        $fileData .= "            <th>$browserName ($browserVersion)</th>\n";
    }
    
    //close table headings
    $fileData .= "        <tr>\n";
    $fileData .= "    </thead>\n";
    $fileData .= "    <tbody>\n";
    
    //get all posible properties
    $properties = $databaseModel->getProperties($elementID);
    
    //loop over each property
    foreach($properties as $property)
    {
        //property details
        $propertyID = $property['ID'];
        $propertyName = $property['Name'];
        
        //update with progress
        echo "Processing $propertyName row" . PHP_EOL;
        
        //open row
        $fileData .= "        <tr>\n";
        
        //add property name
        $fileData .= "            <td>$propertyName</td>\n";
        
        //get value for each browser
        foreach($browsers as $browser)
        {
            //browser details
            $browserID = $browser['ID'];
            
            //get value
            $value = $databaseModel->getPropertyValue($elementID, $browserID, $propertyName);

            //write column with value
            $fileData .= "            <td>$value</td>\n";
        }
        
        //close row
        $fileData .= "        </tr>\n";
    } 

    echo "##### COMPLETED $elementName table #####" . PHP_EOL;
    
    //close table
    $fileData .= "    </tbody>\n";
    $fileData .= "</table>";
    
    //write all data to file
    file_put_contents($file, $fileData, LOCK_EX);
}
