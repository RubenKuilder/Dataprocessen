<?php
// require headers
header("Acces-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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
	$executions_arr = array();
	$executions_arr["executions"] = array();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$execution_item = array(
			"id" => $id,
			"date" => $Date,
			"name" => $Name,
			"age" => $Age,
			"sex" => $Sex,
			"race" => $Race,
			"crime" => $Crime,
			"victimCount" => $Victim_Count,
			"victimSex" => $Victim_Sex,
			"victimRace" => $Victim_Race,
			"county" => $County,
			"state" => $State,
			"region" => $Region,
			"method" => $Method,
			"juvenile" => $Juvenile,
			"volunteer" => $Volunteer,
			"federal" => $Federal,
			"foreignNational" => $Foreign_National
		);

		array_push($executions_arr["executions"], $execution_item);
	}

	http_response_code(200);

	echo json_encode($executions_arr);
} else {
	http_response_code(404);

	echo json_encode(
		array("message" => "No executions were found.")
	);
}
?>