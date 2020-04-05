<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/executionUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

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

// If posted data is found, update database
if($data) {
	//set ID property of execution to be edited
	$executionUSA->id = $data->id;

	// set execution property values
	$executionUSA->year = $data->year;
	$executionUSA->name = $data->name;
	$executionUSA->age = $data->age;
	$executionUSA->sex = $data->sex;
	$executionUSA->race = $data->race;
	$executionUSA->crime = $data->crime;
	$executionUSA->victim_count = $data->victim_count;
	$executionUSA->victim_sex = $data->victim_sex;
	$executionUSA->victim_race = $data->victim_race;
	$executionUSA->county = $data->county;
	$executionUSA->state = $data->state;
	$executionUSA->region = $data->region;
	$executionUSA->method = $data->method;
	$executionUSA->juvenile = $data->juvenile;
	$executionUSA->volunteer = $data->volunteer;
	$executionUSA->federal = $data->federal;
	$executionUSA->foreign_national = $data->foreign_national;

	if($executionUSA->update()) {
		// Response code - 200 OK
		http_response_code(200);

		// Show success message
		echo json_encode(array("message" => "Execution was updated."));
	} else {
		// Response code - 503 SERVICE UNAVAILABLE
		http_response_code(503);

		// Show error message
		echo json_encode(array("message" => "Unable to update execution."));
	}
} else {
	// Response code - 400 BAD REQUEST
	http_response_code(400);

	// Show error message
	echo json_encode(array("message" => "Make sure to provide all data."));
}

?>