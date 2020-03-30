<?php
class HomelessnessUSA {
	// Connect to database and table name
	private $conn;
	private $table_name = "homelessnessUSA";

	// Get properties
	public $where;
	public $what;

	// Object properties
	public $id;
	public $year;
	public $state;
	public $CoC_Number;
	public $CoC_Name;
	public $Measures;
	public $Count;

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
		$query = "INSERT INTO " . $this->table_name . " SET year=:year, state=:state, coc_number=:coc_number, coc_name=:coc_name, measures=:measures, count=:count";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->year = htmlspecialchars(strip_tags($this->year));
		$this->state = htmlspecialchars(strip_tags($this->state));
		$this->coc_number = htmlspecialchars(strip_tags($this->coc_number));
		$this->coc_name = htmlspecialchars(strip_tags($this->coc_name));
		$this->measures = htmlspecialchars(strip_tags($this->measures));
		$this->count = htmlspecialchars(strip_tags($this->count));

		// bind values
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":state", $this->state);
		$stmt->bindParam(":coc_number", $this->coc_number);
		$stmt->bindParam(":coc_name", $this->coc_name);
		$stmt->bindParam(":measures", $this->measures);
		$stmt->bindParam(":count", $this->count);

		// execute query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}

	// update the execution
	function update() {
		// update query
		$query = "UPDATE " . $this->table_name . " SET year=:year, state=:state, coc_number=:coc_number, coc_name=:coc_name, measures=:measures, count=:count WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->year = htmlspecialchars(strip_tags($this->year));
		$this->state = htmlspecialchars(strip_tags($this->state));
		$this->coc_number = htmlspecialchars(strip_tags($this->coc_number));
		$this->coc_name = htmlspecialchars(strip_tags($this->coc_name));
		$this->measures = htmlspecialchars(strip_tags($this->measures));
		$this->count = htmlspecialchars(strip_tags($this->count));

		// bind values
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":year", $this->year);
		$stmt->bindParam(":state", $this->state);
		$stmt->bindParam(":coc_number", $this->coc_number);
		$stmt->bindParam(":coc_name", $this->coc_name);
		$stmt->bindParam(":measures", $this->measures);
		$stmt->bindParam(":count", $this->count);

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