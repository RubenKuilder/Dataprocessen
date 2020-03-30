<?php
class CrimeUSA {
	// Connect to database and table name
	private $conn;
	private $table_name = "crimeUSA";

	// Get properties
	public $where;
	public $what;

	// Object properties
	public $id;
	public $jurisdiction;
	public $year;
	public $crime_reporting_change;
	public $crimes_estimated;
	public $state_population;
	public $violent_crime_total;
	public $murder_manslaughter;
	public $rape_legacy;
	public $rape_revised;
	public $robbery;
	public $agg_assault;
	public $property_crime_total;
	public $burglary;
	public $larceny;
	public $vehicle_theft;

	// constructor with $db as database connection
	public function __construct($db) {
		$this->conn = $db;
	}

	// read executions
	function read() {
		// select query
		$query = "SELECT * FROM " . $this->table_name;

		$stmt = $this->conn->prepare($query);

		$stmt->execute();

		return $stmt;
	}

	// read one kind of product
	function readOne() {

		// sanitize before query
		$this->where=htmlspecialchars(strip_tags($this->where));
		$this->what=htmlspecialchars(strip_tags($this->what));

		// query
		$query = "SELECT * FROM " . $this->table_name . " WHERE " . $this->where . " = :what";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindValue(':what', $this->what, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt;
	}

	// create execution
	function create() {
		// query to insert record
		$query = "INSERT INTO " . $this->table_name . " SET jurisdiction=:jurisdiction, year=:year, crime_reporting_change=:crime_reporting_change, crimes_estimated=:crimes_estimated, state_population=:state_population, violent_crime_total=:violent_crime_total, murder_manslaughter=:murder_manslaughter, rape_legacy=:rape_legacy, rape_revised=:rape_revised, robbery=:robbery, agg_assault=:agg_assault, property_crime_total=:property_crime_total, burglary=:burglary, larceny=:larceny, vehicle_theft=:vehicle_theft";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->jurisdiction = htmlspecialchars(strip_tags($this->jurisdiction));
		$this->year = htmlspecialchars(strip_tags($this->year));
		$this->crime_reporting_change = htmlspecialchars(strip_tags($this->crime_reporting_change));
		$this->crimes_estimated = htmlspecialchars(strip_tags($this->crimes_estimated));
		$this->state_population = htmlspecialchars(strip_tags($this->state_population));
		$this->violent_crime_total = htmlspecialchars(strip_tags($this->violent_crime_total));
		$this->murder_manslaughter = htmlspecialchars(strip_tags($this->murder_manslaughter));
		$this->rape_legacy = htmlspecialchars(strip_tags($this->rape_legacy));
		$this->rape_revised = htmlspecialchars(strip_tags($this->rape_revised));
		$this->robbery = htmlspecialchars(strip_tags($this->robbery));
		$this->agg_assault = htmlspecialchars(strip_tags($this->agg_assault));
		$this->property_crime_total = htmlspecialchars(strip_tags($this->property_crime_total));
		$this->burglary = htmlspecialchars(strip_tags($this->burglary));
		$this->larceny = htmlspecialchars(strip_tags($this->larceny));
		$this->vehicle_theft = htmlspecialchars(strip_tags($this->vehicle_theft));

		// bind values
		$stmt->bindParam(":jurisdiction", $this->jurisdiction);
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":jurisdiction", $this->jurisdiction);
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":crime_reporting_change", $this->crime_reporting_change);
		$stmt->bindParam(":crimes_estimated", $this->crimes_estimated);
		$stmt->bindParam(":state_population", $this->state_population);
		$stmt->bindParam(":violent_crime_total", $this->violent_crime_total);
		$stmt->bindParam(":murder_manslaughter", $this->murder_manslaughter);
		$stmt->bindParam(":rape_legacy", $this->rape_legacy);
		$stmt->bindParam(":rape_revised", $this->rape_revised);
		$stmt->bindParam(":robbery", $this->robbery);
		$stmt->bindParam(":agg_assault", $this->agg_assault);
		$stmt->bindParam(":property_crime_total", $this->property_crime_total);
		$stmt->bindParam(":burglary", $this->burglary);
		$stmt->bindParam(":larceny", $this->larceny);
		$stmt->bindParam(":vehicle_theft", $this->vehicle_theft);

		// execute query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}

	// update the execution
	function update() {
		// update query
		$query = "UPDATE " . $this->table_name . " SET jurisdiction=:jurisdiction, year=:year, crime_reporting_change=:crime_reporting_change, crimes_estimated=:crimes_estimated, state_population=:state_population, violent_crime_total=:violent_crime_total, murder_manslaughter=:murder_manslaughter, rape_legacy=:rape_legacy, rape_revised=:rape_revised, robbery=:robbery, agg_assault=:agg_assault, property_crime_total=:property_crime_total, burglary=:burglary, larceny=:larceny, vehicle_theft=:vehicle_theft WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->year = htmlspecialchars(strip_tags($this->year));
		$this->crime_reporting_change = htmlspecialchars(strip_tags($this->crime_reporting_change));
		$this->crimes_estimated = htmlspecialchars(strip_tags($this->crimes_estimated));
		$this->state_population = htmlspecialchars(strip_tags($this->state_population));
		$this->violent_crime_total = htmlspecialchars(strip_tags($this->violent_crime_total));
		$this->murder_manslaughter = htmlspecialchars(strip_tags($this->murder_manslaughter));
		$this->rape_legacy = htmlspecialchars(strip_tags($this->rape_legacy));
		$this->rape_revised = htmlspecialchars(strip_tags($this->rape_revised));
		$this->robbery = htmlspecialchars(strip_tags($this->robbery));
		$this->agg_assault = htmlspecialchars(strip_tags($this->agg_assault));
		$this->property_crime_total = htmlspecialchars(strip_tags($this->property_crime_total));
		$this->burglary = htmlspecialchars(strip_tags($this->burglary));
		$this->larceny = htmlspecialchars(strip_tags($this->larceny));
		$this->vehicle_theft = htmlspecialchars(strip_tags($this->vehicle_theft));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":jurisdiction", $this->jurisdiction);
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":crime_reporting_change", $this->crime_reporting_change);
		$stmt->bindParam(":crimes_estimated", $this->crimes_estimated);
		$stmt->bindParam(":state_population", $this->state_population);
		$stmt->bindParam(":violent_crime_total", $this->violent_crime_total);
		$stmt->bindParam(":murder_manslaughter", $this->murder_manslaughter);
		$stmt->bindParam(":rape_legacy", $this->rape_legacy);
		$stmt->bindParam(":rape_revised", $this->rape_revised);
		$stmt->bindParam(":robbery", $this->robbery);
		$stmt->bindParam(":agg_assault", $this->agg_assault);
		$stmt->bindParam(":property_crime_total", $this->property_crime_total);
		$stmt->bindParam(":burglary", $this->burglary);
		$stmt->bindParam(":larceny", $this->larceny);
		$stmt->bindParam(":vehicle_theft", $this->vehicle_theft);

		// execute the query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}

	// delete the execution
	function delete() {
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind id
		$stmt->bindParam(1, $this->id);

		// execute query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}
}
?>