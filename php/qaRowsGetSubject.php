<?php 

class qaRowsGetSubject {

	public $returnJson;

	function __construct($dbh, $username) {
		$this->dbh = $dbh;
		$this->username = $username;
	}

	function callMethods() {
		$this->getRows();
	}

	function getRows(){
		$queryRows = $this->dbh->query("SELECT subject FROM qarows WHERE 
			usr = '$this->username' ORDER BY updatetimeunicode DESC LIMIT 1");
		$queryRows = $queryRows->fetch(PDO::FETCH_ASSOC);
		
		#Add error whatever / json, here.

		$_SESSION['qaSubject'] = $queryRows['subject'];

		//$_SESSION['qaSubject'] = 
		#$testJson = json_encode($queryRows);
		#$this->returnJson = $testJson;*/
	}
}

?>