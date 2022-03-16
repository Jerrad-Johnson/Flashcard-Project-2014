<?php include "mysqlicon.php";

	$emailCreation = $_POST['emailCreation'];

	if ($con->connect_error) {
	    die("Connection failed: " . $con->connect_error);
	}


	$result = mysqli_query($con, "SELECT * FROM members WHERE email = '$emailCreation'");

	while ($row = mysqli_fetch_array($result)) {
		$resultPass = $row['email'];  
		echo "E-mail address is already in use.";
	} 

	if(!isset($resultPass)) {
		echo "E-mail address is not already in use.";
	}

	mysqli_close($con);

?>