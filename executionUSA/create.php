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

// make sure data is not empty
if(
	!empty($data->year) &&
	!empty($data->name) &&
	!empty(is_numeric($data->age)) &&
	!empty($data->sex) &&
	!empty($data->race) &&
	!empty($data->crime) &&
	!empty(is_numeric($data->victim_count)) &&
	!empty($data->victim_sex) &&
	!empty($data->victim_race) &&
	!empty($data->county) &&
	!empty($data->state) &&
	!empty($data->region) &&
	!empty($data->method) &&
	!empty($data->juvenile) &&
	!empty($data->volunteer) &&
	!empty($data->federal) &&
	!empty($data->foreign_national)
) {
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

	// create the execution
	if($executionUSA->create()) {
		// Response code - 201 CREATED
		http_response_code(201);

		// Show success message
		echo json_encode(array("message" => "Execution was created."));
	} else {
		// Response code - 503 SERVICE UNAVAILABLE
		http_response_code(503);

		// Show error message
		echo json_encode(array("message" => "Unable to create execution."));
	}
} else {
	// Response code - 400 BAD REQUEST
	http_response_code(400);

	// Show error message
	echo json_encode(array("message" => "Unable to create execution. Data is incomplete."));
}
?>