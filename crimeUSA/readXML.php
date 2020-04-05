<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/xml; charset=utf-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/crimeUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$crimeUSA = new CrimeUSA($db);

// query crimes
$stmt = $crimeUSA->read();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$xml = new SimpleXMLElement("<crimeUSA></crimeUSA>");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
		extract($row);

		$crime = $xml->addChild("crime");
		$xmlID = $crime->addChild("id", $id);
		$xmlJurisdiction = $crime->addChild("jurisdiction", $jurisdiction);
		$xmlYear = $crime->addChild("year", $year);
		$xmlCrimeReportingChange = $crime->addChild("crime_reporting_change", $crime_reporting_change);
		$xmlCrimesEstimated = $crime->addChild("crimes_estimated", $crimes_estimated);
		$xmlStatePopulation = $crime->addChild("state_population", $state_population);
		$xmlViolentCrimeTotal = $crime->addChild("violent_crime_total", $violent_crime_total);
		$xmlMurderManslaughter = $crime->addChild("murder_manslaughter", $murder_manslaughter);
		$xmlRapeLegacy = $crime->addChild("rape_legacy", $rape_legacy);
		$xmlRapeRevised = $crime->addChild("rape_revised", $rape_revised);
		$xmlRobbery = $crime->addChild("robbery", $robbery);
		$xmlAggAssault = $crime->addChild("agg_assault", $agg_assault);
		$xmlPropertyCrimeTotal = $crime->addChild("property_crime_total", $property_crime_total);
		$xmlBurglary = $crime->addChild("burglary", $burglary);
		$xmlLarceny = $crime->addChild("larceny", $larceny);
		$xmlVehicleTheft = $crime->addChild("vehicle_theft", $vehicle_theft);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show xml
	echo $xml->asXML();

} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	$xml = new SimpleXMLElement("<message>No crimes were found.</message>");
}
?>