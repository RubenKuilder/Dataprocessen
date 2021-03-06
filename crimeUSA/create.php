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

// make sure data is not empty
if(
	!empty($data->jurisdiction) &&
	!empty(is_numeric($data->year)) &&
	!empty(is_numeric($data->crime_reporting_change)) &&
	!empty(is_numeric($data->crimes_estimated)) &&
	!empty(is_numeric($data->state_population)) &&
	!empty(is_numeric($data->violent_crime_total)) &&
	!empty(is_numeric($data->murder_manslaughter)) &&
	!empty(is_numeric($data->rape_legacy)) &&
	!empty(is_numeric($data->rape_revised)) &&
	!empty(is_numeric($data->robbery)) &&
	!empty(is_numeric($data->agg_assault)) &&
	!empty(is_numeric($data->property_crime_total)) &&
	!empty(is_numeric($data->burglary)) &&
	!empty(is_numeric($data->larceny)) &&
	!empty(is_numeric($data->vehicle_theft))
) {
	// set crime property values
	$crimeUSA->jurisdiction = $data->jurisdiction;
	$crimeUSA->year = $data->year;
	$crimeUSA->crime_reporting_change = $data->crime_reporting_change;
	$crimeUSA->crimes_estimated = $data->crimes_estimated;
	$crimeUSA->state_population = $data->state_population;
	$crimeUSA->violent_crime_total = $data->violent_crime_total;
	$crimeUSA->murder_manslaughter = $data->murder_manslaughter;
	$crimeUSA->rape_legacy = $data->rape_legacy;
	$crimeUSA->rape_revised = $data->rape_revised;
	$crimeUSA->robbery = $data->robbery;
	$crimeUSA->agg_assault = $data->agg_assault;
	$crimeUSA->property_crime_total = $data->property_crime_total;
	$crimeUSA->burglary = $data->burglary;
	$crimeUSA->larceny = $data->larceny;
	$crimeUSA->vehicle_theft = $data->vehicle_theft;

	// create the crime
	if($crimeUSA->create()) {
		// Response code - 201 CREATED
		http_response_code(201);

		// Show success message
		echo json_encode(array("message" => "Crime was created."));
	} else {
		// Response code - 503 SERVICE UNAVAILABLE
		http_response_code(503);

		// Show error message
		echo json_encode(array("message" => "Unable to create crime."));
	}
} else {
	// Response code - 400 BAD REQUEST
	http_response_code(400);

	// Show error message
	echo json_encode(array("message" => "Unable to create crime. Data is incomplete."));
}
?>