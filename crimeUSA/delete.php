<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/crimeUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$crimeUSA = new CrimeUSA($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//set ID property of crime to be edited
$crimeUSA->id = $data->id;

if($crimeUSA->delete()) {
	// set response code to 200 (ok)
	http_response_code(200);

	// tell the used the crime was updated
	echo json_encode(array("message" => "Crime was deleted."));
} else {
	// set response code to 503 (service unavailable)
	http_response_code(503);

	// tell the used the crime wasn't updated
	echo json_encode(array("message" => "Unable to delete crime."));
}

?>