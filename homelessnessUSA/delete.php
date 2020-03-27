<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/homelessnessUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$homelessnessUSA = new HomelessnessUSA($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//set ID property of homelessness entry to be edited
$homelessnessUSA->id = $data->id;

if($homelessnessUSA->delete()) {
	// set response code to 200 (ok)
	http_response_code(200);

	// tell the used the homelessness entry was updated
	echo json_encode(array("message" => "Homelessness entry was deleted."));
} else {
	// set response code to 503 (service unavailable)
	http_response_code(503);

	// tell the used the homelessness entry wasn't updated
	echo json_encode(array("message" => "Unable to delete homelessness entry."));
}

?>