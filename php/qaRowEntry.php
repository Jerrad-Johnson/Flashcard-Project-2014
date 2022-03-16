<?php
session_start();

# Prevent the database from overwriting with blank entries.
# Lower max entry string length.

include "pdo_ConStart.php";

/*TODO
callMethods isn't being returned a value in the function call.
*/



if(!isset($_SESSION['qaSubject'])){
	die("Error: Please try reloading the page.");
}


if(isset($_SESSION['Username']) && isset($_SESSION['Authorized'])){
	$username = $_SESSION['Username'];	
	$authorized = $_SESSION['Authorized'];
	$question = null;
	$answer = null;
	$creationTimeNatural = date("Y-m-d H:i:s");
	$creationTimeUnicode = time();

	$testvar = new qaRowCreation($dbh, $creationTimeNatural, $creationTimeUnicode, 
								$_SESSION['Username'], $_SESSION['Authorized'], 
								$question, $answer, $_SESSION['qaSubject']);
	$testvar->callMethods();
	echo $testvar->returnEntryString;
	echo $testvar->returnInt;
} else {
	$arr = ["returnLoginJson" => "Please Login."];
	$arr = json_encode($arr);
	echo $arr;
}




class qaRowCreation {

	public $returnEntryString;
	public $returnInt;

	function __construct($dbh, $creationTimeNatural, $creationTimeUnicode, 
							$username, $authorized, $question, $answer, $qaSubject){
		$this->dbh = $dbh;
		$this->creationTimeNatural = $creationTimeNatural;
		$this->creationTimeUnicode = $creationTimeUnicode;
		$this->username = $username;
		$this->authorized = $authorized;
		$this->question = $question;
		$this->answer = $answer;
		$this->qaSubject = $qaSubject;
	}

/* TODO
get sort # of last row in this subject, then +1 the new row's sort #.
Add updatetime
*/

	function callMethods(){
		/*
		if($authorized="true"){*/ 
		$this->returnEntryString = $this->countEntries();
		/*} else {
			echo "Please Login.";
		}*/ 

	}

	function countEntries(){
		$countEntries = $this->dbh->query("SELECT id FROM qarows WHERE usr='$this->username'");
		$countEntries = $countEntries->rowCount();
# ADD subject check
# ADD && title = 'null'

		if($countEntries <= 100) {
            $this->qaRowFind();
		} else {
			# Update the line below
			$returnEntryString = "You have more than 100 entries, please remove some before continuing.";
			// Encode the response, and return it
			$arr = ["returnEntryJson" => "$returnEntryString"];
			return json_encode($arr); 
			// End
		}
	}

    function qaRowFind(){
        $integerCount = $this->dbh->query("SELECT sort FROM qarows
                        WHERE usr='$this->username'
                        AND subject='$this->qaSubject' ORDER BY sort DESC LIMIT 1");
        $integerCount = $integerCount->fetch(PDO::FETCH_COLUMN);
        $integerCount++;
        $this->createEntry($integerCount);
        #TODO Add error handler
    }


	function createEntry($integerCount){
			
			# add if !isset username
		
			$create = $this->dbh->prepare("
				INSERT INTO qarows (creationTimeUnicode, creationTimeNatural,
				questions, answers, usr, subject, sort)
				VALUES(:creationTimeUnicode, :creationTimeNatural,
				:questions, :answers, :usr, :subject, $integerCount)
				");
			$create->execute(array(
				':creationTimeUnicode' => $this->creationTimeUnicode,
				':creationTimeNatural' => $this->creationTimeNatural,
				':questions' => $this->question,
				':answers' => $this->answer,
				':usr' => $this->username, // Why do I have an extra comma?
				':subject' => $this->qaSubject
				));
			$this->returnInt = $this->returnInt(); // If the script creates a new row, it will return the number to the public variable.
 	}

	function returnInt(){
		$returnInt = $this->dbh->query("SELECT id FROM qarows WHERE usr='$this->username' AND subject='$this->qaSubject' ORDER BY id DESC LIMIT 1");
		$returnInt = $returnInt->fetchObject();
		$returnInt = $returnInt->id;

			// Encode the integer, and return it to createEntry's call to this function. 
		$arr = ["returnIntJson" => "$returnInt"];
		return json_encode($arr);
			// End
	}
}

// End

?>