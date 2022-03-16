<?php 
session_start();
#include "php/pdo_ConStart.php";
include "php/session_expire.php";

// On submit, set password form to BLANK.
// By default, check REMEMBER ME.
?>


<!DOCTYPE html>
<!-- Set to UTF 8 --> 
    <html>
        <head>

            <link rel="stylesheet" href="css/styles.css" media="screen" />
            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/var_dump.js"></script>
            
        </head>    
        <body>


	<form name="creation" action="" method="post">

	<input 	required type="text" 
			id="username"
						placeholder="Username"> <br />

	<input 	required type="password" 
			id="password"
			placeholder="Password"> <br />

	Remember Me: <input type="checkbox"
			id="noExpire">

	<br />
	<input type="button" value="Submit" id="submit">
	<div id="result" style="margin-top:20px;"></div>


<script>


// Call submitLogin function on enter or when clicking Submit.

	$("#submit").click(function(){
		submitLogin();
	});

	$("#password").keyup(function (f){
		if (f.keyCode == 13) {
			submitLogin();
		}
	});

// End


// POST to php, get sessions and print PHP response.

 	function submitLogin(){
	    $.post("php/verifylogin.php", { 
	    	loginUsername:$('#username').val(), 
	    	loginPassword:$('#password').val(),
	    	noExpire:$('#noExpire').prop("checked")
	    }, function(data){
	        $("#result").text(data);
	    });
	}

// End


</script>

<?php
var_dump($_SESSION);
$time = time();
echo "<br />" . $time;

?>



	</body>
</html>
