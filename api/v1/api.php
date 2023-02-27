<?php
require("config.php");

////////////////////
// REQUEST HANDLE //
////////////////////

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);


/////////////////////
// RESPONSE HANDLE //
/////////////////////

//Create Response Array
$data_output = array("version" => VERSION);

//Set Content Type to JSON
header("Content-Type: application/json");

//Output Response Array
echo json_encode($data_output);
?>