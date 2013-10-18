<?php

include("../database/DatabaseModel.class.php");

$databaseModel = new DatabaseModel();

//get lsit of browsers
$browsers = $databaseModel->getBrowsers();

//get list of elements
$elements = $databaseModel->getElements();

//foreach element, create a table, with a column for each browser
foreach($elements as $element) {
    $elementID = $element['ID'];
    $elementName = $element['Name'];
    $elementType = $element['Type'];
    
    foreach($browsers as $browser) {
        $browserID = $browser['ID'];
        $browserName = $browser['Name'];
    }
}