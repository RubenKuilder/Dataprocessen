<?php
// require headers
header("Acces-Control-Allow-Origin: *");
header('Content-Type: text/xml; charset=utf-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/executionUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

$executionUSA->where = $_GET['where'];
$executionUSA->what = $_GET['what'];

// query executions
$stmt = $executionUSA->search();
$num = $stmt->rowCount();

if($num > 0) {
	$xml = new SimpleXMLElement("<executionUSA></executionUSA>");
	// $xml->addAttribute('', '');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$execution = $xml->addChild('execution');
		// $execution->addAttribute('', '');
		$xmlID = $execution->addChild("id", $id);
		$xmlYear = $execution->addChild("year", $year);
		$xmlName = $execution->addChild("name", $name);
		$xmlAge = $execution->addChild("age", $age);
		$xmlSex = $execution->addChild("sex", $sex);
		$xmlRace = $execution->addChild("race", $race);
		$xmlCrime = $execution->addChild("crime", $crime);
		$xmlVictimCount = $execution->addChild("victim_count", $victim_count);
		$xmlVictimSex = $execution->addChild("victim_sex", $victim_sex);
		$xmlVicitimRace = $execution->addChild("victim_race", $victim_race);
		$xmlCounty = $execution->addChild("county", $county);
		$xmlState = $execution->addChild("state", $state);
		$xmlRegion = $execution->addChild("region", $region);
		$xmlMethod = $execution->addChild("method", $method);
		$xmlJuvenile = $execution->addChild("juvenile", $juvenile);
		$xmlVolunteer = $execution->addChild("volunteer", $volunteer);
		$xmlFederal = $execution->addChild("federal", $federal);
		$xmlForeignNational = $execution->addChild("foreign_national", $foreign_national);
	}

	http_response_code(200);

	echo $xml->asXML();

} else {
	http_response_code(404);

	$xml = new SimpleXMLElement("<message>No executions were found.</message>");
}
?>