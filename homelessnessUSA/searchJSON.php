<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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

// query executions
$stmt = $homelessnessUSA->readOne();
$num = $stmt->rowCount();

if($num > 0) {
	$homeless_arr = array();
	$homeless_arr["homeless"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$homeless_item = array(
			"id" => $id,
			"year" => $year,
			"state" => $state,
			"coc_number" => $coc_number,
			"coc_name" => $coc_name,
			"measures" => $measures,
			"count" => $count
		);

		array_push($homeless_arr["homeless"], $homeless_item);
	}

	http_response_code(200);

	echo json_encode($homeless_arr);
} else {
	http_response_code(404);

	echo json_encode(
		array("message" => "No homelessness entries were found.")
	);
}
?>