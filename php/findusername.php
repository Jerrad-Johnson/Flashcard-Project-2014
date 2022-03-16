<?php include "mysqlicon.php";

	$userCreation = $_POST['userCreation'];

	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}



	$result = mysqli_query($con, "SELECT * FROM members WHERE usr = '$userCreation'");



	while ($row = mysqli_fetch_array($result)) {
		$resultPass = $row['usr'];  
		echo "Username already taken.";
	} 

	if(!isset($resultPass)) {
		echo "Username is not in use.";
	}

	mysqli_close($con);

?>