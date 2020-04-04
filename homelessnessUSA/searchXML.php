<?php
// require headers
header("Acces-Control-Allow-Origin: *");
header('Content-Type: text/xml; charset=utf-8');

// include database and object files
include_once '../config/database.php';
include_once '../objects/homelessnessUSA.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$homelessnessUSA = new HomelessnessUSA($db);

$homelessnessUSA->where = $_GET['where'];
$homelessnessUSA->what = $_GET['what'];

// query homelessness
$stmt = $homelessnessUSA->search();
$num = $stmt->rowCount();

if($num > 0) {
	$xml = new SimpleXMLElement("<homelessnessUSA></homelessnessUSA>");
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

	http_response_code(200);

	echo $xml->asXML();

} else {
	http_response_code(404);

	$xml = new SimpleXMLElement("<message>No homeless entries were found.</message>");
}