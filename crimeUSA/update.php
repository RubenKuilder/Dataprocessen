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

// If posted data is found, update database
if($data) {
	//set ID property of crime to be edited
	$crimeUSA->id = $data->id;

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

	if($crimeUSA->update()) {
		// Response code - 200 OK
		http_response_code(200);

		// Show success message
		echo json_encode(array("message" => "Crime was updated."));
	} else {
		// Response code - 503 SERVICE UNAVAILABLE
		http_response_code(503);

		// Show error message
		echo json_encode(array("message" => "Unable to update crime."));
	}
} else {
	// Show error message
	echo json_encode(array("message" => "Make sure to provide all data."));
}

?>