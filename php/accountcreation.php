<?php include "mysqlicon.php" ?>



<?php

// CHANGE TO PREPARED STATEMENTS
// Compares entries to PHP's regex, and create a database entry with account details.

	class accountcreation {
		private $options;

		function __construct($con, $ipCreation) {
			$this->passwordCreation = $_POST['passwordCreation'];
			$this->userCreation = $_POST['userCreation'];
			$this->ipCreation = $ipCreation;
			$this->emailCreation = $_POST['emailCreation'];
			$this->con = $con;
		}


		function callMethods() {
			$this->emailRegex();
		}


		private function emailRegex() {
			if (isset($this->emailCreation)) {
				if (preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', 
						$this->emailCreation)) {
				$this->usernameRegex();
				} else {
				echo "Please enter a valid e-mail address.";
				}
			}
		}


		private function usernameRegex() {
			if (preg_match('^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$^', $this->userCreation)) {
			$this->passwordRegex();
			} else {
			echo "Your username must be 3-20 characters long, and only
			contain A-Z, 0-9, or periods and underscores (but not two 
				periods or underscores together.)";
			}
		}


		private function passwordRegex() {
			if(preg_match('^([1-zA-Z0-1@.\s]{4,30})$^', $this->passwordCreation)) {
				$this->passwordHash();
				} else {
				echo "Your password must be 4-30 characters long, and 
					not contain: " . ' ‘ , \* &amp; $ &lt; &gt; ';
			}
		}



		private function passwordHash(){
			$options = array(); $options['cost'] = 12;
			$this->passwordCreation = password_hash($this->passwordCreation, PASSWORD_BCRYPT, $options);
			$this->accountCreation();
		}


		private function accountCreation() {
			#Change to prepared statements.
			mysqli_query($this->con, "INSERT INTO members (usr, pass, email, regIP) 
			VALUES ('$this->userCreation', '$this->passwordCreation', '$this->emailCreation', '$this->ipCreation')");
			echo "Account created.";
			#Set password CHAR to 60
		}
	}


	$ipCreation = $_SERVER['REMOTE_ADDR'];
	$admin = new accountcreation($con, $ipCreation);
	$admin->callMethods();

?>


