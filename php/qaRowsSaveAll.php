<?php

session_start();
include "pdo_ConStart.php";
include "kint/Kint.class.php";
/*

Add check to see if he has saved too recently.

*/

	if(isset($_POST['ids'])){
		$ids = $_POST['ids'];
	} else {
		die("Error: Please try logging in again.");
	}

	if(isset($_POST['Questions'])){
		$questions = $_POST['Questions'];
		// Do I need to do a foreach, and if !isset, $questions = ""; ? so that it won't return an error (question is undefined)
	}
	
	if(isset($_POST['Answers'])){
		$answers = $_POST['Answers'];
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


$updateTimeUnicode = time();
$updateTimeNatural = date("Y-m-d H:i:s");

$call = new qaRowUpdate($dbh, $updateTimeUnicode, $updateTimeNatural, $answers, 
						$questions, $username, $authorized, $ids);
$call->callMethods();


	if(isset($call->returnJsonError)){
		var_dump($call->returnJsonError);
		die();
	} else {
		echo $call->returnJsonSuccess;
	}



class qaRowUpdate {

	public $returnJson;


	function __construct(	$dbh, $updateTimeUnicode, $updateTimeNatural, $answers, 
							$questions, $username, $authorized, $id) {
		$this->dbh = $dbh;
		$this->updateTimeUnicode = $updateTimeUnicode;
		$this->updateTimeNatural = $updateTimeNatural;
		$this->answers = $answers;
		$this->questions = $questions;
		$this->username = $username;
		$this->authorized = $authorized;
		$this->id = $id;
	}


	function callMethods() {
		$this->checkLogin();
	}


	function checkLogin() {
		if ($this->authorized == true && $this->username != null) {

			foreach($this->id as $key => $id){
			$question = $this->questions[$key];
			$answer = $this->answers[$key];
#change to query
			$compare = $this->dbh->prepare("SELECT id FROM `qarows` WHERE usr=:username");
			$compare->bindParam(':username', $this->username);
			$compare->execute();
			$compare = $compare->fetchAll(PDO::FETCH_COLUMN);

			if(in_array($id, $compare)){
				$update = $this->dbh->prepare("
					UPDATE qarows SET 
					questions=:questions,
					answers=:answers,
					updateTimeUnicode=:updateTimeUnicode,
					updateTimeNatural=:updateTimeNatural 
					WHERE id=:id
				");

				$update->execute(array(
					':questions' => $question, 
					':answers' => $answer,
					':updateTimeUnicode' => $this->updateTimeUnicode,
					':updateTimeNatural' => $this->updateTimeNatural,
					':id' => $id
				));

				$arr = ["responseSuccess" => "Successfully updated"];
				$arr = json_encode($arr);
				$this->returnJsonSuccess = $arr;

			} else {
				$arr = ["responseError" => "We're sorry, we did not find an entry to update. Please try logging in."];
				json_encode($arr);
				$this->returnJsonError = $arr;
				break; 
			}
			}
		}
	}
}

?>
