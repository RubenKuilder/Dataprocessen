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

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
	!empty($data->year) &&
	!empty($data->name) &&
	!empty(is_numeric($data->age)) &&
	!empty($data->sex) &&
	!empty($data->race) &&
	!empty($data->crime) &&
	!empty(is_numeric($data->victimCount)) &&
	!empty($data->victimSex) &&
	!empty($data->victimRace) &&
	!empty($data->county) &&
	!empty($data->state) &&
	!empty($data->region) &&
	!empty($data->method) &&
	!empty($data->juvenile) &&
	!empty($data->volunteer) &&
	!empty($data->federal) &&
	!empty($data->foreignNational)
) {
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

	// create the execution
	if($executionUSA->create()) {
		http_response_code(201);

		echo json_encode(array("message" => "Execution was created."));
	} else {
		http_response_code(503);

		echo json_encode(array("message" => "Unable to create execution."));
	}
} else {
	http_response_code(400);

	echo json_encode(array("message" => "Unable to create execution. Data is incomplete."));
}
?>