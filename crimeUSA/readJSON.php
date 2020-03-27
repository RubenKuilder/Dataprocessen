<?php
// require headers
header("Acces-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/crimeUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$crimeUSA = new CrimeUSA($db);

// query executions
$stmt = $crimeUSA->read();
$num = $stmt->rowCount();

if($num > 0) {
	$crimes_arr = array();
	$crimes_arr["crimes"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

		array_push($crimes_arr["crimes"], $crime_item);
	}

	http_response_code(200);

	echo json_encode($crimes_arr);
} else {
	http_response_code(404);

	echo json_encode(
		array("message" => "No crimes were found.")
	);
}
?>