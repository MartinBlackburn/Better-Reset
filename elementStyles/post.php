<?php

include("../database/DatabaseModel.class.php");

$update = new DatabaseModel();


//save browsers
$browserName = isset($_POST["browserName"]) ? $_POST["browserName"] : false;
$browserVersion = isset($_POST["broswerVersion"]) ? $_POST["broswerVersion"] : false;
if($browserName && $browserVersion) {
	echo $update->saveBrowser($browserName, $browserVersion);
}


//save elements
$elementName = isset($_POST["elementName"]) ? $_POST["elementName"] : false;
$elementType = isset($_POST["elementType"]) ? $_POST["elementType"] : "";
if($elementName) {
	echo $update->saveElement($elementName, $elementType);
}


//save properties
$propertyName = isset($_POST["propertyName"]) ? $_POST["propertyName"] : false;
$propertyValue = isset($_POST["propertyValue"]) ? $_POST["propertyValue"] : false;
$elementID = isset($_POST["elementID"]) ? $_POST["elementID"] : false;
$browserID = isset($_POST["browserID"]) ? $_POST["browserID"] : false;
if($propertyName && $propertyValue && $elementID && $browserID) {
	echo $update->saveProperty($propertyName, $propertyValue, $elementID, $browserID);
}