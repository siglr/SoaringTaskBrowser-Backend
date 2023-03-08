<?php
require("config.php");
error_reporting(0);

////////////////////
// REQUEST HANDLE //
////////////////////

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

//Create Response Array
$data_output = array("version" => VERSION);

if (!isset($_GET['endpoint'])) {
    $data_output['error'] = "no_endpoint";
    sendResponse($data_output);
    exit();
} else {
    $endpoint = $_GET['endpoint'];
}
$endpoint = strtolower($endpoint);
switch ($endpoint) {
    default:
        $data_output['error'] = "invalid_endpoint";
        sendResponse($data_output);
        exit();
    case 'gettask':
        if (!isset($_GET['id'])) {
            $data_output['error'] = "no_id";
            sendResponse($data_output);
            exit();
        } else {
            $id = $_GET['id'];
        }
        $data_output['endpoint'] = $endpoint;
        $statement = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $statement->execute(array($id));
        $response = $statement->fetch();
        $task = array(
            "id" => $response['id'],
            "name" => $response['name'],
            "author" => $response['author'],
            "length" => $response['length'],
            "difficulty" => $response['difficulty'],
            "likes" => $response['likes'],
            "dislikes" => $response['dislikes'],
            "description" => $response['description'],
            "dphx_file" => $response['dphx_file']
        );
        $data_output["task"] = $task;
        break;
}


sendResponse($data_output);

/////////////////////
// RESPONSE HANDLE //
/////////////////////
function sendResponse($data_output)
{
    //Set Content Type to JSON
    header("Content-Type: application/json");

    //Output Response Array
    echo json_encode($data_output);
}
