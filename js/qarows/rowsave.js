
// Save a single row.

	$(document).on("click", ".saverowCSS",function() {
	  	var singleAnswerInteger = ($(this).data('integer-save'));
	  	var singleAnswerText = $('[data-integer-answer="'+singleAnswerInteger+'"]').val();
	  	var singleQuestionText = $('[data-integer-question="'+singleAnswerInteger+'"]').val();
		jsonUpdateSingleRow(singleAnswerInteger, singleAnswerText, singleQuestionText);
	});

// End


// Delete a single row.

	$(document).on("click", ".deleterowCSS",function() {
		var integerCount = ($(this).data('integer-delete'));
		jsonDeleteRow(integerCount);
	});

// End


// Save and delete row(s)

	function jsonUpdateSingleRow(integer, answer, question){
		$.post("php/qaRowUpdate.php", {
			'id':integer,
			'Question':question,
			'Answer':answer
		}, function(data){
	    	obj = JSON.parse(data);
	    	jsonResponseUpdateSingleRow(obj);
	   	});
	}


	function jsonSaveAllRows(integerCount, questionContainer, answerContainer){
		$.post("php/qaRowsSaveAll.php", {
			'ids':integerCount,
			'Questions':questionContainer,
			'Answers':answerContainer
		}, function(data){
	    	obj = JSON.parse(data);
	    	jsonResponseSaveAllRows(obj);
	   	});
	}

	function jsonDeleteRow (integerCount){
		$.post("php/qaRowDelete.php", {
			'id':integerCount
		}, function(data){
	    	obj = JSON.parse(data);
	    	jsonResponseDeleteRow(obj);
	   	});
	}
// End


// Handle JSON resposnes from saving and deleting rows.

	function jsonResponseUpdateSingleRow(obj){
		if (typeof obj.responseSuccess != 'undefined') {
			document.getElementById("testjson").innerHTML = obj.responseSuccess;
			$('[data-integer-question="'+obj.responseId+'"]').toggleClass("questioninputsavedCSS", 1000);
			$('[data-integer-answer="'+obj.responseId+'"]').toggleClass("answerinputsavedCSS", 1000);
			$('[data-integer-question="'+obj.responseId+'"]').toggleClass("questioninputsavedCSS", 1000);
			$('[data-integer-answer="'+obj.responseId+'"]').toggleClass("answerinputsavedCSS", 1000);
		} else if (typeof obj.responseError != 'undefined'){ 
			document.getElementById("testjson").innerHTML = obj.responseError;
		}
	}

	function jsonResponseSaveAllRows(obj){
		if (typeof obj.responseSuccess != 'undefined'){
			document.getElementById("testjson").innerHTML = obj.responseSuccess;
			$('[data-integer-question]').toggleClass("questioninputsavedCSS", 1300);
			$('[data-integer-answer]').toggleClass("answerinputsavedCSS", 1300);
			$('[data-integer-question]').toggleClass("questioninputsavedCSS", 1300);
			$('[data-integer-answer]').toggleClass("answerinputsavedCSS", 1300);
		} else if (typeof obj.responseError != 'undefined') {
			document.getElementById("testjson").innerHTML = obj.responseError;
		}
	}

	function jsonResponseDeleteRow(obj){
		$("#qarowcontainer-"+obj.returnInteger).fadeOut(1200, function(){
            $(this).remove();
        });
	//	var_dump(test);
	}

// End


// Save All rows

	function saveAllRows(){
		var count = countExistingRows();

		var integerCount = new Array();
		var questionContainer = new Array();
		var answerContainer = new Array();

		for(i=0; i < count; i++){
			integerCount[i] = document.getElementsByClassName("questioninputcss")[i].getAttribute("data-integer-question");
			questionContainer[i] = $('[data-integer-question="'+integerCount[i]+'"]').val();
			answerContainer[i] = $('[data-integer-answer="'+integerCount[i]+'"]').val();
		}

		jsonSaveAllRows(integerCount, questionContainer, answerContainer);
	}

// End


// Detect keypress, and call function

var saveArray = new Array();
saveArray[0] = false;
saveArray[1] = false;

$(document).ready(function(){

	$(document).keydown(function (f){
		if (f.keyCode == 16) {
			saveArray[0] = true;
		}
	});

	$(document).keyup(function (g){
		if(g.which == 16){
			saveArray[0] = false;
		}
	});

	$(document).keydown(function (h){
		if (h.keyCode == 83) {
			saveArray[1] = true;
			if(saveArray[0] == true && saveArray[1] == true){
				saveArray[0] = false;
				saveArray[1] = false;
				keypressSaveFunction();
			}
		}
	});

	$(document).keyup(function (i){
		if (i.which == 83) {
			saveArray[1] = false;
		}
	});
});

	function keypressSaveFunction(){
		saveAllRows();
	}

// End