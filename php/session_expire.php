<?php 

if(isset($_SESSION['Expire'])) {
	if($_SESSION['Expire'] < time()){
		session_unset();
	}
}

?>