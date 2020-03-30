<?php
// require headers
header("Acces-Control-Allow-Origin: *");
header('Content-Type: application/xml; charset=utf-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/executionUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

// query executions
$stmt = $executionUSA->read();
$num = $stmt->rowCount();

if($num > 0) {
	// One way of making an XML element
	// $xml = new DOMDocument('1.0');
	// $rootElement = $xml->createElement("executionUSA");
	// $xml->appendChild($rootElement);
	// while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	// 	extract($row);

	// 	// ID element
	// 	$idElement = $xml->createElement("id");
	// 	$idElementText = $xml->createTextNode($id);
	// 	$idElement->appendChild($idElementText);

	// 	// Name element
	// 	$nameElement = $xml->createElement("name");
	// 	$nameElementText = $xml->createTextNode($Name);
	// 	$nameElement->appendChild($nameElementText);

	// 	// Person element
	// 	$personElement = $xml->createElement("person");
	// 	$personElement->appendChild($idElement);
	// 	$personElement->appendChild($nameElement);

	// 	$rootElement->appendChild($personElement);
	// }

	// Another way of making an XML document
	$xml = new SimpleXMLElement("<executionUSA></executionUSA>");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$execution = $xml->addChild("execution");
		$execution->addChild("id", $id);
		$execution->addChild("year", $year);
		$execution->addChild("name", $name);
		$execution->addChild("age", $age);
		$execution->addChild("sex", $sex);
		$execution->addChild("race", $race);
		$execution->addChild("crime", $crime);
		$execution->addChild("victimCount", $victim_count);
		$execution->addChild("victimSex", $victim_sex);
		$execution->addChild("victimRace", $victim_race);
		$execution->addChild("county", $county);
		$execution->addChild("state", $state);
		$execution->addChild("region", $region);
		$execution->addChild("method", $method);
		$execution->addChild("juvenile", $juvenile);
		$execution->addChild("volunteer", $volunteer);
		$execution->addChild("federal", $federal);
		$execution->addChild("foreignNational", $foreign_national);
	}

	http_response_code(200);

	print $xml->asXML();

} else {
	http_response_code(404);

	$xml = new SimpleXMLElement("<message>No executions were found.</message>");
}
?>