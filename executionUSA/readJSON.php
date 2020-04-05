<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/executionUSA.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();

// initialize object
$executionUSA = new ExecutionUSA($db);

// query executions
$stmt = $executionUSA->read();
$num = $stmt->rowCount();

// If data is found, process it into an array
if($num > 0) {
	$executions_arr = array();
	$executions_arr["executions"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		// Extract $row
		extract($row);

		$execution_item = array(
			"id" => $id,
			"year" => $year,
			"name" => $name,
			"age" => $age,
			"sex" => $sex,
			"race" => $race,
			"crime" => $crime,
			"victim_count" => $victim_count,
			"victim_sex" => $victim_sex,
			"victim_race" => $victim_race,
			"county" => $county,
			"state" => $state,
			"region" => $region,
			"method" => $method,
			"juvenile" => $juvenile,
			"volunteer" => $volunteer,
			"federal" => $federal,
			"foreign_national" => $foreign_national
		);

		// Push data into executions_arr["executions"]
		array_push($executions_arr["executions"], $execution_item);
	}

	// Response code - 200 OK
	http_response_code(200);

	// Show executions_arr JSON
	echo json_encode($executions_arr);
} else {
	// Response code - 404 NOT FOUND
	http_response_code(404);

	// Show error message
	echo json_encode(
		array("message" => "No executions were found.")
	);
}
?>