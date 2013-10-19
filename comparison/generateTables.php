<?php

include("../database/DatabaseModel.class.php");

$databaseModel = new DatabaseModel();

//get lsit of browsers
$browsers = $databaseModel->getBrowsers();

//get list of elements
$elements = $databaseModel->getElements();

//number of columns
$numCols = count($browsers) + 1;

//foreach element, create a table, with a column for each browser
foreach($elements as $element)
{
	//element details
    $elementID = $element['ID'];
    $elementName = $element['Name'];
    $elementType = $element['Type'];
    
	echo "Creating $elementName table" . PHP_EOL;
    
    //create file
    $file = 'elements/' . $elementName . '-' . $elementType . '.html';
    $fileData = "<table>\n";
    $fileData .= "    <thead>\n";
    $fileData .= "        <tr>\n";
    $fileData .= "            <th colspan='$numCols'>$elementName</th>\n";
    $fileData .= "        <tr>\n";
    $fileData .= "    </thead>\n";
    $fileData .= "    <tbody>\n";
    file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
    
    foreach($browsers as $browser) {
        $browserID = $browser['ID'];
        $browserName = $browser['Name'];
        
        $styles = $databaseModel->getStyles($elementID, $browserID);
    }
    
    //close file
    $fileData = "    </tbody>\n";
    $fileData = "</table>";
    file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
}