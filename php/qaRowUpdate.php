<?php

session_start();
include "pdo_ConStart.php";


# Turn response into JSON
# Prevent overloading



	if(isset($_POST['id'])){
		$id = $_POST['id'];
	} else {
		die("Error: Please try logging in again.");
	}

	if(isset($_POST['Question'])){

		if(strlen($_POST['Question']) < 21000) {
			$question = $_POST['Question'];
		} else {
			echo "Your question/challenge field is longer than 21,000 characters. Please shorten it.";
		}

	} else {
		$question = null;
	}
	
	
	if(isset($_POST['Answer'])){
		if(strlen($_POST['Answer']) < 21000) {
			$answer = $_POST['Answer'];
		} else {
			die("Your answer/challenge field is longer than 21,000 characters. Please shorten it.");
		}

	} else {
		$answer = null;
	}


	if(isset($_SESSION['Username'])){
		$username = $_SESSION['Username'];
	} else {
		$username = null;
	}

	if($_SESSION['Authorized'] == true){
		$authorized = $_SESSION['Authorized'];
	} else {
		$authorized = false;
	}

	if(isset($_SESSION['qaSubject'])){
		$qaSubject = $_SESSION['qaSubject'];
	} else {
		die("Error: Please try reloading the page.");
	}



$updateTimeUnicode = time();
$updateTimeNatural = date("Y-m-d H:i:s");

$call = new qaRowUpdate($dbh, $updateTimeUnicode, $updateTimeNatural, $answer, 
						$question, $username, $authorized, $id);
$call->callMethods();
echo $call->returnJson;





// Why don't I get an error, if it's already created?

class qaRowUpdate {

	public $returnJson;


	function __construct(	$dbh, $updateTimeUnicode, $updateTimeNatural, $answer, 
							$question, $username, $authorized, $id) {
		$this->dbh = $dbh;
		$this->updateTimeUnicode = $updateTimeUnicode;
		$this->updateTimeNatural = $updateTimeNatural;
		$this->answer = $answer;
		$this->question = $question;
		$this->username = $username;
		$this->authorized = $authorized;
		$this->id = $id;
	}

	function callMethods() {
		$this->checkLogin();
	}

	function checkLogin() {
		if ($this->authorized == true && $this->username != null) {
			$this->compareDatabase();
		} else {
			$arr = ["responseError" => "Please login."];
			json_encode($arr);
			$this->returnJson = $arr;
		}
	}

	function compareDatabase(){

		$compare = $this->dbh->prepare("SELECT id FROM `qarows` WHERE usr=:username");
		$compare->bindParam(':username', $this->username);
		$compare->execute();
		$compare = $compare->fetchAll(PDO::FETCH_COLUMN);

		if(in_array($this->id, $compare)){
			$this->updateDatabase($compare);
		} else {
			$arr = ["responseError" => "We're sorry, we did not find an entry to update. Please try logging in."];
			json_encode($arr);
			$this->returnJson = $arr;
			

		}
	}

	function updateDatabase($compare){
		$update = $this->dbh->prepare("
				UPDATE qarows SET 
				questions=:questions,
				answers=:answers,
				updateTimeUnicode=:updateTimeUnicode,
				updateTimeNatural=:updateTimeNatural 
				WHERE id=:id
				");

		$update->execute(array(
			':questions' => $this->question, 
			':answers' => $this->answer,
			':updateTimeUnicode' => $this->updateTimeUnicode,
			':updateTimeNatural' => $this->updateTimeNatural,
			':id' => $this->id
			));

			$arr = ["responseSuccess" => "Successfully updated", "responseId" => "$this->id"];
			$arr = json_encode($arr);
			$this->returnJson = $arr;
		
		# Add error handler
	}
}

?>
