<?php
session_start();
include "pdo_ConStart.php";

$position = $_POST['sortid'];
$username = $_SESSION['Username'];
$subject = $_SESSION['qaSubject'];

$delimiterSort = "qarowcontainer[]=";
$position = explode($delimiterSort, $position);
$holder = "";

foreach ($position as $key){
    $holder .= $key;
}
/*TODO
Add error checking to database statement, and to delimiter, etc.
Add JSON response.
*/


$delimiterSort = "&";
$id = explode($delimiterSort, $holder);

$callClass = new updateSort($dbh, $subject, $username, $id);
$callClass->getMethods();

class updateSort{

    function __construct($dbh, $subject, $username, $id){
        $this->dbh = $dbh;
        $this->subject = $subject;
        $this->username = $username;
        $this->id = $id;
    }

    function getMethods(){
        $this->eachItemSort();
    }

    function eachItemSort(){
        $index = "0";
        foreach ($this->id as $sort){
            $index++;
            $this->updateSort($sort, $index);
        }
    }

    function updateSort($sort, $index){

        $databaseUpdate = $this->dbh->prepare("UPDATE qarows SET sort='$index'
                    WHERE usr='$this->username' AND id=:id");
        $databaseUpdate->bindParam(':id', $sort);
        $databaseUpdate->execute();
        #handle errors
    }
}

?>