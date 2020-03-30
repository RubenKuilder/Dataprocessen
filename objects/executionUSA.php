<?php
class ExecutionUSA {
	// Connect to database and table name
	private $conn;
	private $table_name = "executionUSA";

	// Get properties
	public $where;
	public $what;

	// Object properties
	public $id;
	public $year;
	public $name;
	public $age;
	public $sex;
	public $race;
	public $crime;
	public $victimCount;
	public $victimSex;
	public $victimRace;
	public $county;
	public $state;
	public $region;
	public $method;
	public $juvenile;
	public $volunteer;
	public $federal;
	public $foreignNational;

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
		$query = "INSERT INTO " . $this->table_name . " SET year=:year, name=:name, age=:age, sex=:sex, race=:race, crime=:crime, victim_Count=:victimCount, victim_Sex=:victimSex, victim_Race=:victimRace, county=:county, state=:state, region=:region, method=:method, juvenile=:juvenile, volunteer=:volunteer, federal=:federal, foreign_National=:foreignNational";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->year=htmlspecialchars(strip_tags($this->year));
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->age=htmlspecialchars(strip_tags($this->age));
		$this->sex=htmlspecialchars(strip_tags($this->sex));
		$this->race=htmlspecialchars(strip_tags($this->race));
		$this->crime=htmlspecialchars(strip_tags($this->crime));
		$this->victimCount=htmlspecialchars(strip_tags($this->victimCount));
		$this->victimSex=htmlspecialchars(strip_tags($this->victimSex));
		$this->victimRace=htmlspecialchars(strip_tags($this->victimRace));
		$this->county=htmlspecialchars(strip_tags($this->county));
		$this->state=htmlspecialchars(strip_tags($this->state));
		$this->region=htmlspecialchars(strip_tags($this->region));
		$this->method=htmlspecialchars(strip_tags($this->method));
		$this->juvenile=htmlspecialchars(strip_tags($this->juvenile));
		$this->volunteer=htmlspecialchars(strip_tags($this->volunteer));
		$this->federal=htmlspecialchars(strip_tags($this->federal));
		$this->foreignNational=htmlspecialchars(strip_tags($this->foreignNational));

		// bind values
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":age", $this->age);
		$stmt->bindParam(":sex", $this->sex);
		$stmt->bindParam(":race", $this->race);
		$stmt->bindParam(":crime", $this->crime);
		$stmt->bindParam(":victimCount", $this->victimCount);
		$stmt->bindParam(":victimSex", $this->victimSex);
		$stmt->bindParam(":victimRace", $this->victimRace);
		$stmt->bindParam(":county", $this->county);
		$stmt->bindParam(":state", $this->state);
		$stmt->bindParam(":region", $this->region);
		$stmt->bindParam(":method", $this->method);
		$stmt->bindParam(":juvenile", $this->juvenile);
		$stmt->bindParam(":volunteer", $this->volunteer);
		$stmt->bindParam(":federal", $this->federal);
		$stmt->bindParam(":foreignNational", $this->foreignNational);

		// execute query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}

	// update the execution
	function update() {
		// update query
		$query = "UPDATE " . $this->table_name . " SET year=:year, name=:name, age=:age, sex=:sex, race=:race, crime=:crime, victim_Count=:victimCount, victim_Sex=:victimSex, victim_Race=:victimRace, county=:county, state=:state, region=:region, method=:method, juvenile=:juvenile, volunteer=:volunteer, federal=:federal, foreign_National=:foreignNational WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));
		$this->year=htmlspecialchars(strip_tags($this->year));
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->age=htmlspecialchars(strip_tags($this->age));
		$this->sex=htmlspecialchars(strip_tags($this->sex));
		$this->race=htmlspecialchars(strip_tags($this->race));
		$this->crime=htmlspecialchars(strip_tags($this->crime));
		$this->victimCount=htmlspecialchars(strip_tags($this->victimCount));
		$this->victimSex=htmlspecialchars(strip_tags($this->victimSex));
		$this->victimRace=htmlspecialchars(strip_tags($this->victimRace));
		$this->county=htmlspecialchars(strip_tags($this->county));
		$this->state=htmlspecialchars(strip_tags($this->state));
		$this->region=htmlspecialchars(strip_tags($this->region));
		$this->method=htmlspecialchars(strip_tags($this->method));
		$this->juvenile=htmlspecialchars(strip_tags($this->juvenile));
		$this->volunteer=htmlspecialchars(strip_tags($this->volunteer));
		$this->federal=htmlspecialchars(strip_tags($this->federal));
		$this->foreignNational=htmlspecialchars(strip_tags($this->foreignNational));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":name", $this->name);
		$stmt->bindParam(":age", $this->age);
		$stmt->bindParam(":sex", $this->sex);
		$stmt->bindParam(":race", $this->race);
		$stmt->bindParam(":crime", $this->crime);
		$stmt->bindParam(":victimCount", $this->victimCount);
		$stmt->bindParam(":victimSex", $this->victimSex);
		$stmt->bindParam(":victimRace", $this->victimRace);
		$stmt->bindParam(":county", $this->county);
		$stmt->bindParam(":state", $this->state);
		$stmt->bindParam(":region", $this->region);
		$stmt->bindParam(":method", $this->method);
		$stmt->bindParam(":juvenile", $this->juvenile);
		$stmt->bindParam(":volunteer", $this->volunteer);
		$stmt->bindParam(":federal", $this->federal);
		$stmt->bindParam(":foreignNational", $this->foreignNational);

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