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

// make sure data is not empty
if(
	!empty($data->year) &&
	!empty($data->state) &&
	!empty($data->coc_number) &&
	!empty($data->coc_name) &&
	!empty($data->measures) &&
	!empty(is_numeric($data->count))
) {
	// set execution property values
	$homelessnessUSA->year = $data->year;
	$homelessnessUSA->state = $data->state;
	$homelessnessUSA->coc_number = $data->coc_number;
	$homelessnessUSA->coc_name = $data->coc_name;
	$homelessnessUSA->measures = $data->measures;
	$homelessnessUSA->count = $data->count;

	// create the homelessness entry
	if($homelessnessUSA->create()) {
		http_response_code(201);

		echo json_encode(array("message" => "homelessness entry was created."));
	} else {
		http_response_code(503);

		echo json_encode(array("message" => "Unable to create homelessness entry."));
	}
} else {
	http_response_code(400);

	echo json_encode(array("message" => "Unable to create homelessness entry. Data is incomplete."));
}
?>