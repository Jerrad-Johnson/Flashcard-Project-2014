// Count number of existing rows, including newly created ones.

	function countExistingRows(){
		var count = document.querySelectorAll('textarea.questioninputcss').length;
		return count; 
	}

// End

// Adjust text areas height to match length.

	$(document).ready(function(){
		 $('.js-questioninput').autosize();
		 $('.js-answerinput').autosize();
	});

// End


// Toggle and reset block/column class

	$(document).ready(function() {
        $("#togglequestions").click(function () {
            $("[data-integer-question]").toggleClass("questioninputcssHidden", 700);
        });

        $("#toggleanswers").click(function () {
            $("[data-integer-answer]").toggleClass("answerinputcssHidden", 700);
        });

        $("#toggleall").click(function () {
            $("[data-integer-question]").toggleClass("questioninputcssHidden", 700);
            $("[data-integer-answer]").toggleClass("answerinputcssHidden", 700);
        });

        $("#reset").click(function () {
            resetAllRows();
        });

        $("#resetquestions").click(function () {
            resetQuestionRows();
        });

        $("#resetanswers").click(function () {
            resetAnswerRows();
        });

        $("#togglerandom").click(function () {
            randomizeExistingRows();
        });

        $("#testwhatever").click(function () {
            saveAllRows();
        });

        $(".deleterowCSS").click(function () {
            testVar();
        });

        $("#preventDefault").submit(function (eSubmit) {
            eSubmit.preventDefault();
        });

        $("#qarowshtml").sortable({
            placeholder: "ui-qarows-placeholder",
            axis: 'y',
            stop: function (event, ui) {
                var dataSort = $(this).sortable('serialize');
                $.post("php/qarowsUpdateSort.php", {
                    'sortid':dataSort
                }, function(data){
//                  obj = JSON.parse(data);
                });
            }});

    });



// End


// Toggle Random Rows

	function randomizeExistingRows(){
		var count = countExistingRows();
		var integerCount = new Array();
		
		for(i=0; i < count; i++){
			integerCount[i] = document.getElementsByClassName("questioninputcss")[i].getAttribute("data-integer-question");
		}
		
		for(i=0; i < count; i++){
			var questionClass = document.getElementsByClassName("questioninputcss")[i].getAttribute("class");
			var answerClass = document.getElementsByClassName("answerinputcss")[i].getAttribute("class");
		
			if(questionClass != "questioninputcss js-questioninput"){
				$('[data-integer-question="'+integerCount[i]+'"]').toggleClass("questioninputcssHidden", 700);
			} 

			if(answerClass != "answerinputcss js-answerinput"){
				$('[data-integer-answer="'+integerCount[i]+'"]').toggleClass("answerinputcssHidden", 700);	
			}
		}

	// Consider adding SLEEP

		for (i = 0; i < count; ++i) {
			a = Math.floor((Math.random() * 10) + 1); 
		
			if(a < 6) {
				$('[data-integer-question="'+integerCount[i]+'"]').toggleClass("questioninputcssHidden", 700);
			} else {
				$('[data-integer-answer="'+integerCount[i]+'"]').toggleClass("answerinputcssHidden", 700);
			}
		}
	}

// End


// Reset column(s) class to default

function resetQuestionRows(){
		var count = countExistingRows();
		var integerCount = new Array();
		
		for(i=0; i < count; i++){
			integerCount[i] = document.getElementsByClassName("questioninputcss")[i].getAttribute("data-integer-question");
		}

		for(i=0; i < count; i++){
			var questionClass = document.getElementsByClassName("questioninputcss")[i].getAttribute("class");
		
			if(questionClass != "questioninputcss js-questioninput"){
				$('[data-integer-question="'+integerCount[i]+'"]').toggleClass("questioninputcssHidden", 700);
			} 
		}
	}

	function resetAnswerRows(){
		var count = countExistingRows();
		var integerCount = new Array();
		
		for(i=0; i < count; i++){
			integerCount[i] = document.getElementsByClassName("answerinputcss")[i].getAttribute("data-integer-answer");
		}

		for(i=0; i < count; i++){
			var answerClass = document.getElementsByClassName("answerinputcss")[i].getAttribute("class");

			if(answerClass != "answerinputcss js-answerinput"){
				$('[data-integer-answer="'+integerCount[i]+'"]').toggleClass("answerinputcssHidden", 700);	
			}
		}
	}


	function resetAllRows(){
		var count = countExistingRows();
		var integerCount = new Array();
		
		for(i=0; i < count; i++){
			integerCount[i] = document.getElementsByClassName("questioninputcss")[i].getAttribute("data-integer-question");
		}

		for(i=0; i < count; i++){
			var questionClass = document.getElementsByClassName("questioninputcss")[i].getAttribute("class");
			var answerClass = document.getElementsByClassName("answerinputcss")[i].getAttribute("class");
		
			if(questionClass != "questioninputcss js-questioninput"){
				$('[data-integer-question="'+integerCount[i]+'"]').toggleClass("questioninputcssHidden", 700);
			} 

			if(answerClass != "answerinputcss js-answerinput"){
				$('[data-integer-answer="'+integerCount[i]+'"]').toggleClass("answerinputcssHidden", 700);	
			}
		}
	}

// End
