<!DOCTYPE html>
<!-- Set to UTF 8 --> 
    <html>
        <head>

            <link rel="stylesheet" href="css/styles.css" media="screen" />
            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/var_dump.js"></script>
            
        </head>    
        <body>


<!-- Account creation form: 
     ADD "NAMES"-->


	<form name="creation" action="" method="post">

<!-- Changed type to email, make sure it works. -->
	E-mail: <input required type="email" id="emailCreation" 
	oninput="emailValidate();" 
	onpaste="this.oninput();">  <!-- This used to be onkeypress, make sure I was right to change it. -->
	<span id="emailRegexJavascriptResponse"></span> <br />

	Username: <input required type="text" id="userCreation"
	onpaste="userValidate();"
	oninput="this.onpaste();">
	<span id="userRegexJavascriptResponse"></span>	<br />
	
	Password: <input required type="password" 
	id="passwordCreation" 
	oninput="passwordValidate();" 
	onpaste="this.oninput();">  <!-- This used to be onkeypress, make sure I was right to change it. -->
	<span id="passwordJavascriptResponse"></span> <br /> 


	<input type="button" value="Submit" id="createaccount">
	<!--<input type="button" value="Submit" onclick="creationResult();"> -->

	<div id="creationresult" style="margin-top:20px;">

<!-- End -->


		<script type="text/javascript">


// Validate form entries
// ADD A LOADING ANIMATION

	// Email Validate

	function emailValidate() {
		var x = document.forms["creation"]["emailCreation"].value;
		var z = emailRegexJavascript.test(x);

		if (z == 0) {
			document.getElementById("emailRegexJavascriptResponse").innerHTML = "Please enter a valid e-mail address.";
		} else {
			document.getElementById("emailRegexJavascriptResponse").innerHTML = "Press enter or continue to the next field.";
		/* Add an if here, for SQL. */
		}
	}

	function emailValidateJQ() {
		var x = document.forms["creation"]["emailCreation"].value;
		var z = emailRegexJavascript.test(x);

		if (z == 0) {
			document.getElementById("emailRegexJavascriptResponse").innerHTML = "Please enter a valid e-mail address.";
		} else {
			document.getElementById("emailRegexJavascriptResponse").innerHTML = "Checking database, please wait.";			
			$.post("php/findemail.php", { emailCreation:$('#emailCreation').val() }, function(data){
	        $("#emailRegexJavascriptResponse").text(data);
	        });
		/* Add an if here, for SQL. */
		}
	}

	// End

	// User Validate 

	function userValidate() {
		var x = document.forms["creation"]["userCreation"].value;
		var y = x.length;
		var z = userRegexJavascript.test(x);
		

		if (y < 3) {
			document.getElementById("userRegexJavascriptResponse").innerHTML = "Please use at least 3 characters.";
		} else {
			if (z == 0) {
				document.getElementById("userRegexJavascriptResponse").innerHTML = "Please enter a valid username.";
			} else {
				if (z == 1) {
					document.getElementById("userRegexJavascriptResponse").innerHTML = "Press enter or continue to the next field.";
				}
			}
		}	
	}

	function userValidateJQ() {
		var x = document.forms["creation"]["userCreation"].value;
		var y = x.length;
		var z = userRegexJavascript.test(x);
		

		if (y < 3) {
			document.getElementById("userRegexJavascriptResponse").innerHTML = "Please use at least 3 characters.";
			} else {
				if (z == 0) {
					document.getElementById("userRegexJavascriptResponse").innerHTML = "Please enter a valid username.";
			} else {
				if (z == 1) {
					document.getElementById("userRegexJavascriptResponse").innerHTML = "Checking database, please wait.";			
					$.post("php/findusername.php", { userCreation:$('#userCreation').val() }, function(data){
	        		$("#userRegexJavascriptResponse").text(data);
	        		});
				}
			}
		}
	}

	// End

	// Password Validate

	function passwordValidate() {
		var x = document.forms["creation"]["passwordCreation"].value;
		var y = x.length;

		if (y < 4) {
			document.getElementById("passwordJavascriptResponse").innerHTML = "Your password must be at least 4 characters long.";
		} else {
			if (y >= 4) {
				document.getElementById("passwordJavascriptResponse").innerHTML = "To continue, press enter or click Submit.";
			}
		}
	}

	// End

// End


// Javascript's Regex

	var emailRegexJavascript = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var userRegexJavascript = /^[a-zA-Z0-9]+$/; /* This needs to allow _ and ., but not double _ or . */

// End


// On field change, or press enter, call function.

	$("#emailCreation").change(function(){
		emailValidateJQ();
	});

	$("#emailCreation").keyup(function (e){
		if (e.keyCode == 13) {
			emailValidateJQ();
		}
	});

	$("#userCreation").change(function(){ 
    userValidateJQ();
    });

	$("#userCreation").keyup(function (f){
		if (f.keyCode == 13) {
			userValidateJQ();
		}
	});

	$("#passwordCreation").change(function(){
		passwordValidate();
	});

	$("#createaccount").click(function(){
		submitAccount();
	});

	$("#passwordCreation").keyup(function (f){
		if (f.keyCode == 13) {
			submitAccount();
		}
	});

// End


// On click, POST information to accountcreation

 	function submitAccount(){
	    $.post("php/accountcreation.php", { 
	    	userCreation:$('#userCreation').val(), 
	    	emailCreation:$('#emailCreation').val(), 
	    	passwordCreation:$('#passwordCreation').val()
	    }, function(data){
	        $("#creationresult").text(data);
	    });
	}

// End

	</script>
		</body>
	</html>