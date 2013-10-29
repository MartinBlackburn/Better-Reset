<?php

include(dirname(__FILE__) . "/../database/DatabaseModel.class.php");

$databaseModel = new DatabaseModel();

//get lsit of browsers
$browsers = $databaseModel->getBrowsers();

//get list of elements
$elements = $databaseModel->getElements();

//number of columns
//+1 for the property name
$numCols = count($browsers) + 1;

//foreach element, create a table, with a column for each browser
foreach($elements as $element)
{
	//element details
    $elementID = $element['ID'];
    $elementName = $element['Name'];
    $elementType = $element['Type'];
    
	echo "##### CREATING $elementName table #####" . PHP_EOL;
    
    //create file
    //overwrite existing
    $filename = $elementName;
    if($elementType) {
        $filename = $filename . '-' . $elementType;
    }
    $file = dirname(__FILE__) . '/elements/test-' . $filename . '.html';
        
    $fileData = "<table>\n";
    $fileData .= "    <thead>\n";
    $fileData .= "        <tr>\n";
    $fileData .= "            <th>Property</th>\n";
    
    //create table headings
    foreach($browsers as $browser) {
        //browser details
        $browserID = $browser['ID'];
        $browserName = $browser['Name'];
        $browserVersion = $browser['Version'];

        $fileData .= "            <th>$browserName ($browserVersion)</th>\n";
    }
    
    //close table headings
    $fileData .= "        <tr>\n";
    $fileData .= "    </thead>\n";
    $fileData .= "    <tbody>\n";
    file_put_contents($file, $fileData, LOCK_EX);
    
    //get all posible properties
    $properties = $databaseModel->getProperties($elementID);
    
    //loop over each property
    foreach($properties as $property) {
        //property details
        $propertyID = $property['ID'];
        $propertyName = $property['Name'];
        
        echo "Processing $propertyName row" . PHP_EOL;
        
        //add property name
        $fileData = "        <tr>\n";
        $fileData .= "            <td>$propertyName</td>\n";
        
        //get value for each browser
        foreach($browsers as $browser) {
            $browserID = $browser['ID'];
            
            $value = $databaseModel->getPropertyValue($elementID, $browserID, $propertyName);
                        
            $fileData .= "            <td>$value</td>\n";
        }
        
        //add row to file
        $fileData .= "        </tr>\n";
        file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
    } 

    echo "##### COMPLETED $elementName table #####" . PHP_EOL;
    
    //close file
    $fileData = "    </tbody>\n";
    $fileData .= "</table>";
    file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
}
