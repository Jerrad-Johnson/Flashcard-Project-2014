<?php
session_start();
include "pdo_ConStart.php";

$deleteRow =  new deleteRow($dbh, $_SESSION['Username'], $_POST['Subject']);
$deleteRow->getMethods();
echo $deleteRow->jsonResponse;

class deleteRow{

	function __construct($dbh, $username, $subject){
		$this->dbh = $dbh;
		$this->username = $username;
		$this->subject = $subject;
        $this->jsonResponse = "";
	}

	function getMethods(){
		$this->delete();
	}

	function delete(){
        $findSubject = $this->dbh->prepare("SELECT subject FROM qarows WHERE usr=:usr
			AND subject=:subject LIMIT 1");
        $findSubject->execute(array(
            ':usr' => $this->username,
            ':subject' => $this->subject));
        $findSubject = $findSubject->fetch(PDO::FETCH_COLUMN);

        if ($findSubject !== false) {
            $removeSubject = $this->dbh->prepare("DELETE FROM qarows
				WHERE usr=:usr AND subject=:subject");
            $removeSubject->execute(array(
                ':usr' => $this->username,
                ':subject' => $this->subject));
            #Add error check

            if ($_SESSION['qaSubject'] == $this->subject) {
                $this->findCurrentFolder();
            } else {
                $arr = ["responseSuccess" => "Folder deleted."];
                $arr = json_encode($arr);
                $this->jsonResponse = $arr;
            }
        } else {
                $arr = ["responseError" =>
                    "We could not find find that folder. Did you already delete it?"];
                $arr = json_encode($arr);
                $this->jsonResponse = $arr;
        }
    }

    // If the user deleted the folder he's currently in, change his session data.
    function findCurrentFolder(){

            $querySubject = $this->dbh->query("SELECT subject FROM qarows WHERE
                usr = '$this->username' ORDER BY updatetimeunicode DESC LIMIT 1");
            $querySubject = $querySubject->fetch(PDO::FETCH_COLUMN);

            $_SESSION['qaSubject'] = $querySubject;
            $arr = ["changeSubject" => "changeSubject",
                "responseSuccess" => "Folder deleted."];
            $arr = json_encode($arr);
            $this->jsonResponse = $arr;

            #TODO add error handling
    }
    // End
}

?>