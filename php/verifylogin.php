<?php
session_start();
session_unset();
include "pdo_ConStart.php";

# Upon signing in, first do a session_unset. For example, if 'remember me' was not checked the first time - the user will still be signed out after 30 minutes.

	class CheckLogin {
		
		function __construct($loginUsername, $loginPassword, $noExpire, $dbh){
			$this->loginUsername = $loginUsername;
			$this->loginPassword = $loginPassword;
			$this->noExpire = $noExpire;
			$this->dbh = $dbh;
		}

		public function callMethods(){
			$this->dbCheckLogin();
		}


		private function dbCheckLogin(){
			$stmt = $this->dbh->prepare("SELECT pass FROM members WHERE usr = :loginUsername");
			$stmt->bindParam(':loginUsername', $this->loginUsername);
			$stmt->execute();
			$result = $stmt->fetchObject(); 
				if($result != null) {
					$this->dbVerifyPassword($result->pass);
				} else {
					echo "Username and password does not match, please try again.";
				}
		}

		private function dbVerifyPassword($result){
			if (password_verify($this->loginPassword, $result)){
				$_SESSION['Authorized'] = true;
				$_SESSION['Username'] = $this->loginUsername;
					if($this->noExpire == "false") {
						$expireIn = time();
						$expireIn += 30*60;
						$_SESSION['Expire'] = $expireIn;
						echo "Logged in, expiration set to 30 minutes.";
					} else {
						echo "Logged in, no expire.";
						// Fixed by using session_unset(); unset($_SESSION['Expire']);				
					}
			} else {
				echo "Username and password does not match, please try again.";
			}
		}


		function closeDb(){
			$dbh = null;
		}
	}
	


$loginUsername = $_POST['loginUsername'];
$loginPassword = $_POST['loginPassword'];
$noExpire = $_POST['noExpire'];


if(!empty($loginUsername) && !empty($loginPassword)) {
	$checkLogin = new CheckLogin($loginUsername, $loginPassword, $noExpire, $dbh);
	$checkLogin->callMethods();
} else {
	echo "Please enter your username and password.";
}


?>
