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
		$execution->addChild("date", $Date);
		$execution->addChild("name", $Name);
		$execution->addChild("age", $Age);
		$execution->addChild("sex", $Sex);
		$execution->addChild("race", $Race);
		$execution->addChild("crime", $Crime);
		$execution->addChild("victimCount", $Victim_Count);
		$execution->addChild("victimSex", $Victim_Sex);
		$execution->addChild("victimRace", $Victim_Race);
		$execution->addChild("county", $County);
		$execution->addChild("state", $State);
		$execution->addChild("region", $Region);
		$execution->addChild("method", $Method);
		$execution->addChild("juvenile", $Juvenile);
		$execution->addChild("volunteer", $Volunteer);
		$execution->addChild("federal", $Federal);
		$execution->addChild("foreignNational", $Foreign_National);
	}

	http_response_code(200);

	print $xml->saveXML();

} else {
	http_response_code(404);

	$xml = new SimpleXMLElement("<message>No executions were found.</message>");
}
?>