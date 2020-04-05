<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/crimeUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$crimeUSA = new CrimeUSA($db);

$crimeUSA->where = $_GET['where'];
$crimeUSA->what = $_GET['what'];

// query executions
$stmt = $crimeUSA->search();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$crimes_arr = array();
	$crimes_arr["crimes"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
		extract($row);

		$crime_item = array(
			"id" => $id,
			"jurisdiction" => $jurisdiction,
			"year" => $year,
			"crime_reporting_change" => $crime_reporting_change,
			"crimes_estimated" => $crimes_estimated,
			"state_population" => $state_population,
			"violent_crime_total" => $violent_crime_total,
			"murder_manslaughter" => $murder_manslaughter,
			"rape_legacy" => $rape_legacy,
			"rape_revised" => $rape_revised,
			"robbery" => $robbery,
			"agg_assault" => $agg_assault,
			"property_crime_total" => $property_crime_total,
			"burglary" => $burglary,
			"larceny" => $larceny,
			"vehicle_theft" => $vehicle_theft
		);

		// Push data into crimes_arr["crimes"]
		array_push($crimes_arr["crimes"], $crime_item);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show crimes_arr JSON
	echo json_encode($crimes_arr);
} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	echo json_encode(
		array("message" => "No crimes were found.")
	);
}
?>