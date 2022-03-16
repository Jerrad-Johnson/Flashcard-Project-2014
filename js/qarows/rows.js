// This finds all pre-existing rows.

function findExistingRows(){
	$.post("php/qaRowsGet.php", {
		}, function(data){
	    	data = JSON.parse(data);

            var myNode = document.getElementById("qarowshtml");
            while (myNode.lastChild) {
                myNode.removeChild(myNode.lastChild);
            }

	    	printExistingRows(data);


	    	// The first function should be a separator, in case of an error response from PHP.
	   	});
}

findExistingRows();

// End


// This loops through the json pre-existing row response,
// separates the array and sends it to a function to be turned into elements.

	function printExistingRows(data){

		for (var key in data) {

		    if (data.hasOwnProperty(key)) {
		      
				var id = data[key].id;
				var questions = data[key].questions;
				var answers = data[key].answers;

					if (typeof questions == "undefined") {
						questions = "";
					}
					if (typeof answers == "undefined") {
						questions = "";
					}

				displayRows(id, questions, answers);
			}
		}
        $('#qarowshtml').fadeIn(500);
	}

// End


// This creates elements, based on pre-existing row data.

	function displayRows(id, question, answer){

		qaRow = document.createElement('div');
		qaRow.setAttribute('id', "qarowcontainer-" + id);
		qaRow.setAttribute('class',"qaRowsCSS");

		qaRowParent = document.getElementById("qarowshtml");
		qaRowParent.appendChild(qaRow);


	// Create forms and their containers


		qaRowQuestion = document.createElement('div');
		qaRowQuestion.setAttribute('id', "qarowquestion" + id);
		qaRowQuestion.setAttribute('class',"questionColumnCSS");

		qaRowQuestionParent = document.getElementById("qarowcontainer-" + id);
		qaRowQuestionParent.appendChild(qaRowQuestion);

		/*var qaRowQuestionForm = document.createElement("form");
		qaRowQuestionForm.setAttribute('method',"post");
		qaRowQuestionForm.setAttribute('action',"submit.php");
		qaRowQuestionForm.setAttribute('class',"questionformcss");*/

		var qaRowQuestionInput = document.createElement("textarea"); //input element, text
		qaRowQuestionInput.setAttribute('type',"text");
		qaRowQuestionInput.setAttribute('data-class-changer',"question");
		qaRowQuestionInput.setAttribute('class',"questioninputcss js-questioninput");
		qaRowQuestionInput.setAttribute('data-integer-question', id);		


		//document.getElementById("qarowquestion" + id).appendChild(qaRowQuestionForm);
		qaRowQuestion.appendChild(qaRowQuestionInput);

		$(function(){ 
			$('[data-integer-question="'+id+'"]').val(question);
		});




		qaRowAnswer = document.createElement('div');
		qaRowAnswer.setAttribute('id', "qarowanswer" + id);
		//qaRowAnswer.setAttribute('data-integer-answer', obj.returnIntJson);
		qaRowAnswer.setAttribute('class',"answerColumnCSS");

		qaRowAnswerParent = document.getElementById("qarowcontainer-" + id);
		qaRowAnswerParent.appendChild(qaRowAnswer);

		/*var qaRowAnswerForm = document.createElement("form");
		qaRowAnswerForm.setAttribute('method',"post");
		qaRowAnswerForm.setAttribute('action',"submit.php");
		qaRowAnswerForm.setAttribute('class',"answerformcss");*/
		
		var qaRowAnswerInput = document.createElement("textarea"); //input element, text
		qaRowAnswerInput.setAttribute('type',"text");
		qaRowAnswerInput.setAttribute('data-class-changer',"answer");
		qaRowAnswerInput.setAttribute('class',"answerinputcss js-answerinput");
		//qaRowAnswerInput.setAttribute('id',rowNumberObj.answernumberinput);
		qaRowAnswerInput.setAttribute('data-integer-answer', id);

		//document.getElementById("qarowanswer" + id).appendChild(qaRowAnswerForm);
		qaRowAnswer.appendChild(qaRowAnswerInput);



	// Add a save button 
		qaRowSave =  document.createElement('div');
		qaRowSave.setAttribute('id', "qarowsave" + id);
		qaRowSave.setAttribute('data-integer-save', id);
		qaRowSave.setAttribute('class',"saverowCSS");

		qaRowSaveParent = document.getElementById("qarowcontainer-" + id);
		qaRowSaveParent.appendChild(qaRowSave);

		qaRowSave.innerHTML = "Save";
	// End

	// Add a delete button 
		qaRowDelete =  document.createElement('div');
		qaRowDelete.setAttribute('id', "qarowdelete" + id);
		qaRowDelete.setAttribute('data-integer-delete', id);
		qaRowDelete.setAttribute('class',"deleterowCSS");

		qaRowDeleteParent = document.getElementById("qarowcontainer-" + id);
		qaRowDeleteParent.appendChild(qaRowDelete);

		qaRowDelete.innerHTML = "Delete";
	// End

		$(function(){ 
			$('[data-integer-answer="'+id+'"]').val(answer);
		});

		$('.js-questioninput').autosize();
		$('.js-answerinput').autosize();

		$('#qarowcontainer-'+id).fadeIn(500);

	}

// End 


// This function gets called, upon getting a positive response for a new row, from PHP.

	function createRow(obj) {

	// Give a unique ID to each div
		var rowNumberObj = {};
		rowNumberObj['qarowcontainer'] = "qarowcontainer-" + obj.returnIntJson;
		rowNumberObj['questionnumber'] = "qarowquestion" + obj.returnIntJson;
		rowNumberObj['questionnumberinput'] = "inputquestion" + obj.returnIntJson;
		rowNumberObj['answernumber'] = "qarowanswer" + obj.returnIntJson;
		rowNumberObj['answernumberinput'] = "inputquestion" + obj.returnIntJson;
	// End

	// Create the single row container div.
		qaRow = document.createElement('div');
		qaRow.setAttribute('id', rowNumberObj.qarowcontainer);
		qaRow.setAttribute('class',"qaRowsCSS");

		qaRowParent = document.getElementById("qarowshtml");
		qaRowParent.appendChild(qaRow);
	// End

	// Create forms and their containers


		qaRowQuestion = document.createElement('div');
		qaRowQuestion.setAttribute('id', rowNumberObj.questionnumber);
		//qaRowQuestion.setAttribute('data-integer-question', obj.returnIntJson);
		qaRowQuestion.setAttribute('class',"questionColumnCSS");

		qaRowQuestionParent = document.getElementById(rowNumberObj.qarowcontainer);
		qaRowQuestionParent.appendChild(qaRowQuestion);

		/*var qaRowQuestionForm = document.createElement("form");
		qaRowQuestionForm.setAttribute('method',"post");
		qaRowQuestionForm.setAttribute('action',"submit.php");
		qaRowQuestionForm.setAttribute('class',"questionformcss");*/

		var qaRowQuestionInput = document.createElement("textarea"); //input element, text
		qaRowQuestionInput.setAttribute('type',"text");
		qaRowQuestionInput.setAttribute('data-class-changer',"question");
		qaRowQuestionInput.setAttribute('class',"questioninputcss js-questioninput");
		qaRowQuestionInput.setAttribute('data-integer-question', obj.returnIntJson);		

		//document.getElementById(rowNumberObj.questionnumber).appendChild(qaRowQuestionForm);
		qaRowQuestion.appendChild(qaRowQuestionInput);




		qaRowAnswer = document.createElement('div');
		qaRowAnswer.setAttribute('id', rowNumberObj.answernumber);
		//qaRowAnswer.setAttribute('data-integer-answer', obj.returnIntJson);
		qaRowAnswer.setAttribute('class',"answerColumnCSS");

		qaRowAnswerParent = document.getElementById(rowNumberObj.qarowcontainer);
		qaRowAnswerParent.appendChild(qaRowAnswer);

		/*var qaRowAnswerForm = document.createElement("form");
		qaRowAnswerForm.setAttribute('method',"post");
		qaRowAnswerForm.setAttribute('action',"submit.php");
		qaRowAnswerForm.setAttribute('class',"answerformcss");*/
		
		var qaRowAnswerInput = document.createElement("textarea"); //input element, text
		qaRowAnswerInput.setAttribute('type',"text");
		qaRowAnswerInput.setAttribute('type',"text");
		qaRowAnswerInput.setAttribute('class',"answerinputcss js-answerinput");
		//qaRowAnswerInput.setAttribute('id',rowNumberObj.answernumberinput);
		qaRowAnswerInput.setAttribute('data-integer-answer', obj.returnIntJson);

		//document.getElementById(rowNumberObj.answernumber).appendChild(qaRowAnswerForm);
		qaRowAnswer.appendChild(qaRowAnswerInput);

		 $('.js-questioninput').autosize();
		 $('.js-answerinput').autosize();


		qaRowSave =  document.createElement('div');
		qaRowSave.setAttribute('id', "qarowsave" + obj.returnIntJson);
		qaRowSave.setAttribute('data-integer-save', obj.returnIntJson);
		qaRowSave.setAttribute('class',"saverowCSS");

		qaRowSaveParent = document.getElementById("qarowcontainer-" + obj.returnIntJson);
		qaRowSaveParent.appendChild(qaRowSave);

		qaRowSave.innerHTML = "Save";

	// Add a delete button 
		qaRowDelete =  document.createElement('div');
		qaRowDelete.setAttribute('id', "qarowdelete" + obj.returnIntJson);
		qaRowDelete.setAttribute('data-integer-delete', obj.returnIntJson);
		qaRowDelete.setAttribute('class',"deleterowCSS");

		qaRowDeleteParent = document.getElementById("qarowcontainer-" + obj.returnIntJson);
		qaRowDeleteParent.appendChild(qaRowDelete);

		qaRowDelete.innerHTML = "Delete";
	// End

		$('#'+rowNumberObj.qarowcontainer).fadeIn(1200);
	}

	// End
// End


// After the user requests a new row, send a request to PHP for a unique ID.

	function jsonGetResponse(){
		$.post("php/qaRowEntry.php", { 
	    }, function(data){
	    	obj = JSON.parse(data);
	   		jsontest(obj);
	    });
	}

// End


// Get integer from PHP for newly created row, so it can be created with the correct integer.

	function jsontest(obj) {
		if (typeof obj.returnIntJson != 'undefined') {
			createRow(obj);
		} else if (typeof obj.returnLoginJson != 'undefined') {
			document.getElementById("testjson").innerHTML = obj.returnLoginJson;
		} else if (typeof obj.returnEntryJson != 'undefined') {
			document.getElementById("testjson").innerHTML = obj.returnEntryJson;
		}
	}

// End


// If the response from PHP for a new row is positive, execute this function.

	$("#qarowcreation").click(function(){
		jsonGetResponse();
	});

// End