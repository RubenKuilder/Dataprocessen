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


if($data) {
	//set ID property of the homelessness entry to be edited
	$homelessnessUSA->id = $data->id;

	// set homeless property values
	$homelessnessUSA->year = $data->year;
	$homelessnessUSA->state = $data->state;
	$homelessnessUSA->coc_number = $data->coc_number;
	$homelessnessUSA->coc_name = $data->coc_name;
	$homelessnessUSA->measures = $data->measures;
	$homelessnessUSA->count = $data->count;

	if($homelessnessUSA->update()) {
		// set response code to 200 (ok)
		http_response_code(200);

		// tell the used the hemelessness entry was updated
		echo json_encode(array("message" => "Homelessness entry was updated."));
	} else {
		// set response code to 503 (service unavailable)
		http_response_code(503);

		// tell the used the homelessness wasn't updated
		echo json_encode(array("message" => "Unable to update homelessness entry."));
	}
} else {
	echo json_encode(array("message" => "Make sure to provide all data."));
}

?>