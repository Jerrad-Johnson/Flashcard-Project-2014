<?php 
session_start();
#include "php/session_expire.php";

if(!isset($_SESSION['Username'])){
echo "Please <a href="."login.php".">login</a>";

    /*<<<heredoc
    <html><head><body>
<script>
alert("Login");
</script>TEST
</body></head></html>

heredoc;*/

    die();
}

?>
<!DOCTYPE html>
<meta charset="UTF-8">

    <html>
        <head>

            <link rel="stylesheet" href="css/styles.css" media="screen" />
            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/var_dump.js"></script> <!-- Remember to remove this, when finished. -->
            <script src="js/jquery-ui.min.js"></script>
            <script src="js/jquery.autosize.js"></script>
            <script src="js/jquery.ui.touch-punch.min.js"></script>

        </head>
        <body>

        	<div id="buttons">


        		<div id="subjects"></div><br /><br />

        	Reset:
        		<div id="resetquestions"> Questions</div> |
        		<div id="resetanswers"> Answers</div> |
        		<div id="reset">Show All</div>
        		<br /><br />
        	Toggle:
        		<div id="togglequestions">Questions</div> | 
        		<div id="toggleanswers">Answers</div> | 
        		<div id="togglerandom">Random</div> | 
        		<div id="toggleall">All</div>
        		
				<br /><br /> 

        	</div>
        	<br />
			<div id="qarowshtml"></div>
            <!-- This is a container for the row creation. -->

			<div id="testwhatever">Save All</div>
            <br />Or press Shift + S to save-all

			<div id="testjson"></div> <!-- PHP's row creation response gets placed here, if the response is negative. -->
			
			<br />
			<form id="preventDefault">
				<button type="button" 
                id="qarowcreation">Create Row</button> 
                <!-- Change to a reload gif, while waiting for repsonse. -->
				<br /><br />
				<input type="text" 
                id="createfolderinput" 
                placeholder="Create folder">
                </input>
                <br />
                <input type="text" 
                id="deletefolderinput" 
                placeholder="Delete folder">
                </input>
			</form>


<script src="js/qarows/subjects.js"></script>
<script src="js/qarows/rows.js"></script>
<script src="js/qarows/rowsave.js"></script>
<script src="js/qarows/roweffects.js"></script>

<script>


/*TODO

Graphs: Add % from completing (being moved to yearly folder). After that,
    start a new graph with a new color, showing a % that's based on the # of attempts,
    after getting into the yearly folder, vs the # required to get into the yearly folder.

Add redirect from login
Prevent users from submitting the new-subject form again, before the previous 
    attempt is finished. (after findExisitngSubjects, which I probably need to clone.)
        Easy solution: reset input value after submitting.
        Set width to match 15char
        Check strlen
        Add regex? Unncessary, unless prepared statements reject injection, instead of 
            making it safe
Add column shuffling
Add row randomizing
Change the order in which lastChild is removed when updating the row and
    subject list, so it happens after the new data comes.
Add feature to randomize ROW POSITION
Add a check for character length, max. 5k.
Add Save button for new rows
Cause TAB to add x spaces 
Handle JSON error responses, including from Logout.
Add loading animation to JSON stuff.
Add effect, to prevent users from creating a row while switching folders? 
    Should be fine, his session is already changed.
Add save/submit button to Create Row function
Prevent spamming of random? (add delay)
Change jQuery effects to CSS effects. (attr instead of toggleClass, 
    with transition linear.)

    Handle users changing to a folder that doesn't exist?
    After deleting a folder, change user's SESSION['Subject']
    Add javascript strlen check to question & answer save
    Change PHP to allow only 2,000 char. strlen entry for Q&A
    Add an icon that shows the elements are sortable.
    Do something with serialized data, so row locations are remembered.
    Should I add randomized sorting?

Handle users deleting their last row. (Already fine?)

Upon deleting the folder the user is already in, change SESSION and reload rows.

Use removechild for re-displaying new folders, after delete/add.
*/



















</script>
	</body>
</html>