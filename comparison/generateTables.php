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
//<tr>
//    <td>property name</td>
//    <td>browser 1 value</td>
//    <td>browser 2 value</td>
//    <td>browser 3 value</td>
//</tr>
foreach($elements as $element)
{
	//element details
    $elementID = $element['ID'];
    $elementName = $element['Name'];
    $elementType = $element['Type'];
    
	echo "Creating $elementName table" . PHP_EOL;
    
    //create file
    $filename = $elementName;
    if($elementType) {
        $filename = $filename . '-' . $elementType;
    }
    $file = 'elements/test/' . $filename . '.html';
    
    $fileData = "<table>\n";
    $fileData .= "    <thead>\n";
    $fileData .= "        <tr>\n";
    $fileData .= "            <th>$elementName</th>\n";
    
    //create table headings
    foreach($browsers as $browser) {
        $browserID = $browser['ID'];
        $browserName = $browser['Name'];
        $browserVersion = $browser['Version'];

        $fileData .= "            <th>$browserName ($browserVersion)</th>\n";
    }
    
    $fileData .= "        <tr>\n";
    $fileData .= "    </thead>\n";
    $fileData .= "    <tbody>\n";
    file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
    
    //$styles = $databaseModel->getStyles($elementID, $browserID);
    
    
    //close file
    $fileData = "    </tbody>\n";
    $fileData = "</table>";
    file_put_contents($file, $fileData, FILE_APPEND | LOCK_EX);
    
    break;
}
