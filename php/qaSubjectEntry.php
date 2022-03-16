<?php
session_start();

# Prevent the database from overwriting with blank entries.
# Lower max entry string length.

include "pdo_ConStart.php";

if(isset($_POST['folderNewName'])){
	$qaSubjectNew = $_POST['folderNewName'];
	if(strlen($qaSubjectNew) <= 0){
		#Add Json
		die("Please use at least one character.");
	}
} else { 
	# Add JSON response. 
	# Add Length check on Javascript's side. Regex also? Probably not.
	die("Please enter a name for your new folder.");
}


if(isset($_SESSION['Username']) && isset($_SESSION['Authorized'])){
	$username = $_SESSION['Username'];	
	$authorized = $_SESSION['Authorized'];
	$question = null;
	$answer = null;
	$creationTimeNatural = date("Y-m-d H:i:s");
	$creationTimeUnicode = time();
	

	$newSubject = new qaRowCreation($dbh, $creationTimeNatural, $creationTimeUnicode, 
			$_SESSION['Username'], $_SESSION['Authorized'], $question, $answer, 
			$qaSubjectNew);
	$newSubject->callMethods();
	echo $newSubject->returnEntryString; #This should be throwing an error any time a field is successfully added. Fix it.
	echo $newSubject->returnInt;

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
		$this->qaSubject = $qaSubject;
	}

	function callMethods(){
		/*
		if($authorized="true"){*/ 
		$this->compareSubject();
		/*} else {
			echo "Please Login.";
		}*/ 
	}

	function compareSubject(){
		
		$compare = $this->dbh->query("SELECT DISTINCT subject FROM qarows 
			WHERE usr='$this->username'");
		$compare = $compare->fetchAll(PDO::FETCH_COLUMN);

        $index = "0";

// Set to lowercase, for comparison - to see if it already exists. Mysql queries are
// apparently case-sensitive, and entries are not. (did I say that backwards?)

        foreach ($compare as $qaSubjectCompare){
            $compareArray[$index] = strtolower("$qaSubjectCompare");
        }
        $qaSubject = strtolower("$this->qaSubject");

		if(in_array($qaSubject, $compareArray)){
			$returnEntryString = "This subject already exists, please choose a different name.";
			// Encode the response, and return it
			$arr = ["returnEntryJson" => "$returnEntryString"];
			$this->returnEntryString =  json_encode($arr);
		} else { 
		$this->countSubjects();
		}
// End
	}

	function countSubjects(){
		$countSubjects = $this->dbh->query("SELECT DISTINCT subject FROM qarows 
			WHERE usr='$this->username'");
		$countSubjects = $countSubjects->rowCount();


		if($countSubjects <= 20) {
			$this->createEntry();
			
		} else {
			# Update the line below
			$returnEntryString = "You have more than 20 subjects, please remove some before continuing.";
			// Encode the response, and return it
			$arr = ["returnEntryJson" => "$returnEntryString"];
			$arr = json_encode($arr);
			$this->returnEntryString = $arr;
			// End
		}
	}

	function createEntry(){
			
		# add if !isset username
	
		$create = $this->dbh->prepare("
			INSERT INTO qarows (creationTimeUnicode, creationTimeNatural, usr, subject) 
			VALUES('$this->creationTimeUnicode', '$this->creationTimeNatural', '$this->username', :subject)
			");
		$create->bindParam(':subject', $this->qaSubject);
		$create->execute();
		#Add SQL Error Check
		$returnEntryString = "Successfully added folder " . $this->qaSubject;
		$arr = ["returnSuccessJson" => "$returnEntryString"];
		$arr = json_encode($arr);
		$this->returnEntryString = $arr;
	}
}

// End

?>
