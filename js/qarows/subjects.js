// Get QA Subject Folders

function findExistingSubjects(){
	var myNode = document.getElementById("subjects");
	while (myNode.lastChild) {
	    myNode.removeChild(myNode.lastChild);
	}

	$.post("php/qaSubjectsGet.php", {
		}, function(data){

	    	data = JSON.parse(data);
	    	printExistingSubjects(data);
	   	});
}

findExistingSubjects();

// End


// Prep folder titles

	function printExistingSubjects(data){

		for (var key in data) {

		    if (data.hasOwnProperty(key)) {
		      
				var id = data[key]; // Used to be data[key].subject

				displaySubjects(id);

			}
		}
	}

// End


// Print each folder

	function displaySubjects(id){

		qaRow = document.createElement('div');
		qaRow.setAttribute('data-subject', id);
		qaRow.setAttribute('class', "qaRowSubjectsCSS");
		qaRow.innerHTML=id+" | ";

		qaRowParent = document.getElementById("subjects");
		qaRowParent.appendChild(qaRow);
		$('#subjects').fadeIn(800);
	}

// End


// Send input data to php file, create new folder and re-draw folders.

	function jsonCreateSubject(folderName){
		$.post("php/qaSubjectEntry.php", { 
			'folderNewName':folderName
	    }, function(data){
	    	// setTimeout(findExistingSubjects, 800); 
	    	// This isn't needed, because it takes longer than 800ms to get a reply.
	    	// Adding this makes it too slow. See if I can check json delay, and 
	    	// use that in a calculation for setTimeout
	    	findExistingSubjects();
	    	
	    	//do something with data
	    });
	}

// End


// Change session data, after clicking a folder name.

	$(document).on("click", "[data-subject]",function() {
	  	var folderName = ($(this).data());
	  	jsonChangeCurrentFolder(folderName.subject);
	});

// End


// Switch to a different folder.

	function jsonChangeCurrentFolder(folderName){
		$.post("php/changeFolder.php", {
			'foldername':folderName
		}, function(data){
            $('#qarowshtml').fadeOut(500);
			findExistingRows();
	   	});
	}

// End


// Delete a folder

	function jsonDeleteFolder(subjectName){
		$.post("php/qaSubjectDelete.php", {
			'Subject':subjectName
		}, function(data){
            var_dump(data);
			// if response is: folder delete, then: findExistingRows();
	   	});
	}

// End


// Get input data and create a folder.

		$("#createfolderinput").keyup(function (eFolder) {
			if (eFolder.keyCode == 13) {
		  		var folderName = ($(this).val());
		  		$('#subjects').fadeOut(800);
		  		jsonCreateSubject(folderName);
	  		}
		});

// End

// Get input data and delete a folder.

		$("#deletefolderinput").keyup(function (fFolder) {
			if (fFolder.keyCode == 13) {
		  		var subjectName = ($(this).val());
		  		jsonDeleteFolder(subjectName);
		  		$('#subjects').fadeOut(800).delay()
		  		setTimeout(findExistingSubjects, 800);
	  		}
		});

// End