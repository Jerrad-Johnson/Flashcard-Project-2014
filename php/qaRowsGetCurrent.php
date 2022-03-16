<?php 

class qaRowsGetCurrent {

	public $returnJson;

	function __construct($dbh, $username, $qaSubject) {
		$this->dbh = $dbh;
		$this->username = $username;
		$this->qaSubject = $qaSubject;
	}

	function callMethods() {
		$this->getRows();
	}

	function getRows(){
		$queryRows = $this->dbh->query("SELECT id, questions, answers FROM qarows WHERE 
			usr = '$this->username' AND subject='$this->qaSubject' ORDER BY sort ASC");
		$queryRows = $queryRows->fetchAll(PDO::FETCH_ASSOC);
		$testJson = json_encode($queryRows);
		$this->returnJson = $testJson;
	}
}

?>