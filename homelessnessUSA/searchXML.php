<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/xml; charset=utf-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/homelessnessUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$homelessnessUSA = new HomelessnessUSA($db);

$homelessnessUSA->where = $_GET['where'];
$homelessnessUSA->what = $_GET['what'];

// query homelessness
$stmt = $homelessnessUSA->search();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$xml = new SimpleXMLElement("<homelessnessUSA></homelessnessUSA>");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
		extract($row);

		$homeless = $xml->addChild("homeless");
		$xmlID = $homeless->addChild("id", $id);
		$xmlYear = $homeless->addChild("year", $year);
		$xmlState = $homeless->addChild("state", $state);
		$xmlCocNumber = $homeless->addChild("coc_number", $coc_number);
		$xmlCocName = $homeless->addChild("coc_name", htmlspecialchars($coc_name));
		$xmlMeasures = $homeless->addChild("measures", $measures);
		$xmlCount = $homeless->addChild("count", $count);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show xml
	echo $xml->asXML();

} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	$xml = new SimpleXMLElement("<message>No homeless entries were found.</message>");
}