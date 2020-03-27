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
		// set response code to 200 (ok)
		http_response_code(200);

		// tell the used the crime was updated
		echo json_encode(array("message" => "Crime was updated."));
	} else {
		// set response code to 503 (service unavailable)
		http_response_code(503);

		// tell the used the crime wasn't updated
		echo json_encode(array("message" => "Unable to update crime."));
	}
} else {
	echo json_encode(array("message" => "Make sure to provide all data."));
}

?>