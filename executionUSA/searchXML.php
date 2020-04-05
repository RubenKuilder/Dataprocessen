<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/xml; charset=utf-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/executionUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

$executionUSA->where = $_GET['where'];
$executionUSA->what = $_GET['what'];

// query executions
$stmt = $executionUSA->search();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$xml = new SimpleXMLElement("<executionUSA></executionUSA>");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
		extract($row);

		$execution = $xml->addChild('execution');
		$xmlID = $execution->addChild("id", $id);
		$xmlYear = $execution->addChild("year", $year);
		$xmlName = $execution->addChild("name", $name);
		$xmlAge = $execution->addChild("age", $age);
		$xmlSex = $execution->addChild("sex", $sex);
		$xmlRace = $execution->addChild("race", $race);
		$xmlCrime = $execution->addChild("crime", $crime);
		$xmlVictim_count = $execution->addChild("victim_count", $victim_count);
		$xmlVictim_sex = $execution->addChild("victim_sex", $victim_sex);
		$xmlVicitim_race = $execution->addChild("victim_race", $victim_race);
		$xmlCounty = $execution->addChild("county", $county);
		$xmlState = $execution->addChild("state", $state);
		$xmlRegion = $execution->addChild("region", $region);
		$xmlMethod = $execution->addChild("method", $method);
		$xmlJuvenile = $execution->addChild("juvenile", $juvenile);
		$xmlVolunteer = $execution->addChild("volunteer", $volunteer);
		$xmlFederal = $execution->addChild("federal", $federal);
		$xmlForeign_national = $execution->addChild("foreign_national", $foreign_national);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show xml
	echo $xml->asXML();

} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	$xml = new SimpleXMLElement("<message>No executions were found.</message>");
}
?>