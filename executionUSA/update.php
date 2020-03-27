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

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

// get id of execution to be edited
$data = json_decode(file_get_contents("php://input"));


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
	$executionUSA->victimCount = $data->victimCount;
	$executionUSA->victimSex = $data->victimSex;
	$executionUSA->victimRace = $data->victimRace;
	$executionUSA->county = $data->county;
	$executionUSA->state = $data->state;
	$executionUSA->region = $data->region;
	$executionUSA->method = $data->method;
	$executionUSA->juvenile = $data->juvenile;
	$executionUSA->volunteer = $data->volunteer;
	$executionUSA->federal = $data->federal;
	$executionUSA->foreignNational = $data->foreignNational;

	if($executionUSA->update()) {
		// set response code to 200 (ok)
		http_response_code(200);

		// tell the used the execution was updated
		echo json_encode(array("message" => "Execution was updated."));
	} else {
		// set response code to 503 (service unavailable)
		http_response_code(503);

		// tell the used the execution wasn't updated
		echo json_encode(array("message" => "Unable to update execution."));
	}
} else {
	echo json_encode(array("message" => "Make sure to provide all data."));
}

?>