<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/homelessnessUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$homelessnessUSA = new HomelessnessUSA($db);

// query executions
$stmt = $homelessnessUSA->read();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$homeless_arr = array();
	$homeless_arr["homeless"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
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

		// Push data into homeless_arr["homeless"]
		array_push($homeless_arr["homeless"], $homeless_item);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show homeless_arr JSON
	echo json_encode($homeless_arr);
} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	echo json_encode(
		array("message" => "No homelessness entries were found.")
	);
}
?>