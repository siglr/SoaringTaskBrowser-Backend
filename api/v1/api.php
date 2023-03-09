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

//Get Auth-Token From Header (from: https://stackoverflow.com/a/16311684)
$token = null;
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $matches = array();
    preg_match('/Token token="(.*)"/', $headers['Authorization'], $matches);
    if (isset($matches[1])) {
        $token = $matches[1];
    }
}

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
$data_output['endpoint'] = $endpoint;
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
    case 'gettasks':
        $statement = $pdo->prepare("SELECT * FROM tasks");
        $statement->execute(array());
        while ($row = $statement->fetch()) {
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
            $data_output[$row['id']] = $task;
        }
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
