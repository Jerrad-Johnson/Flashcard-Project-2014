<?php


//Connect to SQL
$con=mysqli_connect("localhost","memory",
	"V0kQMRwf2mTx","memory");

if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// End

$sql="CREATE TABLE QuickChallenge(Question TEXT(4000),Answer TEXT(4000), pkey int NOT NULL PRIMARY KEY AUTO_INCREMENT)";


if (mysqli_query($con,$sql)) {
  echo "Table persons created successfully";
} else {
  echo "Error creating table: " . mysqli_error($con);
}



?>