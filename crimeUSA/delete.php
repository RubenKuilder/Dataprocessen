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

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$crimeUSA = new CrimeUSA($db);

// get posted data
if(json_decode(file_get_contents("php://input")) != NULL) {
	// POST data is JSON format
	$data = json_decode(file_get_contents("php://input"));
} else {
	// POST data is XML format
	$xmlRequestContents = simplexml_load_string(file_get_contents("php://input"));
	$xmlInJSON  = json_encode($xmlRequestContents);
	$data = json_decode($xmlInJSON);
}

//set ID property of crime to be edited
$crimeUSA->id = $data->id;

if(
	!empty(is_numeric($data->id))
) {
	if($crimeUSA->delete()) {
		// Response code - 200 OK
		http_response_code(200);

		// Show success message
		echo json_encode(array("message" => "Crime was deleted."));
	} else {
		// Response code - 503 SERVICE UNAVAILABLE
		http_response_code(503);

		// Show error message
		echo json_encode(array("message" => "Unable to delete crime."));
	}
} else {
	// Response code - 400 BAD REQUEST
	http_response_code(400);

	// Show error message
	echo json_encode(array("message" => "Unable to delete homeless entry. Data is incomplete."));
}

?>