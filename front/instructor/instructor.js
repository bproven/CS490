/* self.instructorUcid
 *     File:        instructor/instructor.js
 *     Author:      Bob Provencher
 *     Created:     Mar 5, 2017
 *     Description: instructor view model
 */

function Instructor( instructorUcid, onPostError ) {
    
    var self = this;

    // data
    self.instructorUcid = instructorUcid;
    self.onPostError = isEmpty( onPostError ) ? function( request ) { stopActivity(); } : onPostError;
    
    // currently selected
    self.currentExamId = null;
    self.currentQuestionId = null;
    self.currentExamGrade = null;

    // current data
    self.questions = [];
    self.exams = [];
    self.testcases = [];
    self.examquestions = [];
    self.feedback = [];
    
    self.lastExamFeedback = null;
    
    // ids

    makeIds( self, "question" );
    makeIds( self, "testCase" );
            
    self.testCaseQuestionId         = "cs490-testcasequestion-id";
    self.testCaseQuestionSignatureId = "cs490-testcasequestion-signature-id";
    
    makeIds( self, "exam" );
    makeIds( self, "examQuestion" );
    makeIds( self, "examQuestionScores" );
    
    self.examQuestionScoresScoreId  = "cs490-examquestionscores-score-id";
    self.examQuestionScoresGradeId  = "cs490-examquestionscores-grade-id";
    
    makeIds( self, "examFeedback" );
    
    makeIds( self, "filteredQuestion" );
    
    self.questionFilterFormId       = "cs490-question-filter-form-id";
    
    // data retrieval methods
    self.getQuestions = function() {

        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.questions = results;
            createAndReplaceElementsById( self.questionListId, "tr", results, 
                function( question ) { 
                    return self.createQuestionElement( question ); 
                } );
            displayById( self.questionListEmptyId, !found );
            displayById( self.questionListHeaderId, found );
            //createAndReplaceElementsById( "questions-list", "option", results, self.createQuestionOptionElement );
            self.filterQuestions();
        };

        post( "../questions.php", null, success, self.onPostError );

    };

    self.getTestCases = function() {

        var data = { 
            questionId: self.currentQuestionId 
        };

        displayById( self.testCaseListEmptyId, false );
        displayById( self.testCaseListHeaderId, false );
        
        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.testcases = results;
            createAndReplaceElementsById( self.testCaseListId, "tr", results, self.createTestcaseElement );
            displayById( self.testCaseListEmptyId, !found );
            displayById( self.testCaseListHeaderId, found );
        };

        post( "../testCases.php", data, success, self.onPostError );

    };
    
    self.getExams = function() {

        // the user
        var data = {
            ownerId: self.instructorUcid
        };

        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.exams = results;
            createAndReplaceElementsById( self.examListId, "tr", results, self.createExamElement );
            displayById( self.examListEmptyId, !found );
            displayById( self.examListHeaderId, found );
        };

        post( "../exams.php", data, success, self.onPostError );

    };
    
    self.getStudentExamGrade = function() {
    
        var data = {
            ucid: self.currentExamUcid,
            examId: self.currentExamId
        };

        var success = function( results ) {
            var found = results.length > 0;
            if ( found ) {
                self.currentExamGrade = results[ 0 ];
                var exam = self.currentExamGrade;
                displayLabelById( self.examQuestionScoresId, true, exam.examName );
                displayLabelById( self.examQuestionScoresScoreId, true, '( ' + exam.score + ' / ' + exam.possible + ' )' );
                displayLabelById( self.examQuestionScoresGradeId, true, getGrade( exam.score, exam.possible ) );
            }
        };
    
        post( "../studentExamGrade.php", data, success, self.onPostError );
    
    };

    self.getStudentExamQuestionScores = function() {

        var data = {
            ucid: self.currentExamUcid,
            examId: self.currentExamId
        };

        displayById( self.examQuestionScoresListEmptyId,  false );
        displayById( self.examQuestionScoresListHeaderId, false );
        
        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.examquestions = results;
            createAndReplaceElementsById( self.examQuestionScoresListId, "tr", results, self.createExamQuestionScoreElement );
            displayById( self.examQuestionScoresListEmptyId, !found );
            displayById( self.examQuestionScoresListHeaderId, found );
        };

        post( "../studentExamQuestionScores.php", data, success, self.onPostError );
        
    };

    self.getExamQuestions = function() {

        var data = {
            examId: self.currentExamId
        };

        displayById( self.examQuestionListEmptyId,  false );
        displayById( self.examQuestionListHeaderId, false );
        
        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.examquestions = results;
            createAndReplaceElementsById( self.examQuestionListId, "tr", results, self.createExamQuestionElement );
            displayById( self.examQuestionListEmptyId, !found );
            displayById( self.examQuestionListHeaderId, found );
        };

        post( "../examQuestions.php", data, success, self.onPostError );
        
    };
    
    self.getFeedback = function() {
        
        var id = this.id;
        
        var data = {
            ucid: self.currentExamUcid,
            examId: self.currentExamId,
            questionId: id
        };
        
        displayById( self.examFeedbackListEmptyId, false );
        displayById( self.examFeedbackListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.feedback = results;
            createAndReplaceElementsById( self.examFeedbackListId, "tr", results, self.createExamFeedbackElement );
            displayById( self.examFeedbackListEmptyId, !found );
            displayById( self.examFeedbackListHeaderId, found );
            doTabClick( 5 );
        };
        
        post( "../studentExamQuestionFeedback.php", data, success, self.onPostError );
        
    };
    
//    self.getExamFeedback = function() {
//
//        var data = {
//            examId: self.currentExamId
//        };
//
//        var success = function( results ) {
//            stopActivity();
//            var found = results.length > 0;
//            self.feedback = results;
//            createAndReplaceElementsById( self.examFeedbackListId, "tr", results, self.createExamFeedbackElement );
//            displayById( self.examFeedbackListEmptyId, !found );
//            displayById( self.examFeedbackListHeaderId, found );
//        };
//
//        post( "../studentExamFeedback.php", data, success, onPostError );
//
//    };

    // UI event handlers
    self.addQuestion = function() {

        // pull out the input fields and create a request object
        var object = formToObjectById( self.questionFormId );

        var fields = [
            "question", "argument1", "returnType", 
            "difficulty", "functionName", 
            "hasIf", "hasWhile", "hasFor", "hasRecursion"
        ];

        var verified = verifyFieldsNotBlank( object, fields );

        if ( verified ) {

            var success = function( results ) {

                stopActivity();

                displayById( self.questionListEmptyId, false );
                displayById( self.questionListHeaderId, false );

                if ( results.success ) {
                    object.questionId = results.questionId;
                    self.questions.push( object );
                    createAndAddElementById( object, self.createQuestionElement, self.questionListId );
                    displayById( self.questionListEmptyId, false );
                    displayById( self.questionListHeaderId, true );
                }

            };

            post( "../addQuestion.php", object, success, self.onPostError );

        }

    };

    self.addExam = function() {

        // pull out the input fields and create a request object
        var object = formToObjectById( self.examFormId );

        var verified = verifyNotBlank ( object.examName, "examName-error", "Exam name cannot be blank" );

        if ( verified ) {

            object.ownerId = instructorUcid;

            var success = function( results ) {

                stopActivity();
            
                if ( results.success ) {
                    object.examId = results.examId;
                    self.exams.push( object );
                    createAndAddElementById( object, self.createExamElement, self.examListId );
                    displayById( self.examListEmptyId, false );
                    displayById( self.examListHeaderId, true );
                }

            };

            post( "../addExam.php", object, success, self.onPostError );

        }

    };

    self.addTestCase = function() {

        var object = formToObjectById( self.testCaseFormId );

        object.questionId = self.currentQuestionId;

        if ( object.questionId !== null ) {

            var fields = [
                "argument1", "returnValue" 
            ];

            var verified = verifyFieldsNotBlank( object, fields );

            if ( verified ) {

                var success = function( results ) {

                    stopActivity();
                    
                    if ( results.success ) {
                        object.testCaseId = results.testCaseId;
                        self.testcases.push( object );
                        createAndAddElementById( object, self.createTestcaseElement, self.testCaseListId );
                        displayById( self.testCaseListEmptyId, false );
                        displayById( self.testCaseListHeaderId, true );
                    }

                };

                post( "../addTestCase.php", object, success, self.onPostError );

            }

        }
        else {

            showError( "testcase-error", "Please choose a question", 3000 );

        }

    };

    self.addToExam = function() {
        
        // pull out the input fields and create a request object
        var object = formToObjectById( self.examQuestionFormId );

        var data = {
            examId: self.currentExamId,
            questionId: object.questionId
        };

        var success = function( results ) {

            stopActivity();
            
            if ( results.success ) {
                self.examquestions.push( data );
                createAndAddElementById( data, self.createExamQuestionElement, self.examQuestionListId );
                displayById( self.examQuestionListEmptyId, false );
                displayById( self.examQuestionListHeaderId, true );
            }

        };

        post( "../addExamQuestion.php", data, success, self.onPostError );

    };
    
    self.scoreExam = function() {

        self.currentExamId = this.id;

        var data = {
            examId: self.currentExamId
        };

        var success = function( results ) {

            if ( results.success ) {
                showError( "examname-error", "Exam Scored!", 3000, 
                function () {
                    self.getStudentExamGrade();
                    self.getStudentExamQuestionScores();
                    doTabClick( 4 );
                } );
            }
            else {
                showError( "examname-error", "Sorry, there was an error scoring the exam.", 3000 );
            }

        };

        post( "../releaseScores.php", data, success, self.onPostError );

    };
    
    self.previewScores = function () {
        
        var id = JSON.parse( this.id );
        
        self.currentExamId = id.examId;
        self.currentExamUcid = id.ucid;
        
        self.getStudentExamGrade();
        self.getStudentExamQuestionScores();
        
        doTabClick( 4 );
        
    };
    
    self.saveScores = function () {
        
        var request = {
            examId: self.currentExamId,
            ucid: self.currentExamUcid,
            scores: []
        };
        
        var objects = formToObjectArrayById( self.examQuestionScoresFormId );
        
        objects.forEach( function( elem ) {
            var score = { questionId: elem.id, score: elem.value };
            request.scores.push( score );
        });

        var success = function( results ) {
            if ( results.success ) {
                self.getStudentExamGrade();
                showError( self.examQuestionScoresErrorId, "Scores Saved!", 3000 );
            }
            else {
                showError( self.examQuestionScoresErrorId, "Sorry, there was an error updating the exam question scores.", 3000 );
            }

        };
        
        post( "../saveScores.php", request, success, self.onPostError );
        
    };
    
    self.manageTestCases = function() {
      
        self.currentQuestionId = this.id;
        
        var question = self.getQuestion( self.currentQuestionId );
        
        displayLabelById( self.testCaseQuestionId, true, question.question );
        displayLabelById( self.testCaseQuestionSignatureId, true, self.getFunctionSignature( question ) );
        
        self.getTestCases();
        
        doTabClick( 1 );
        
    };
    
    self.manageExamQuestions = function () {
      
        self.currentExamId = this.id;
        
        var exam = self.currentExam();
        
        displayLabelById( self.examQuestionId, true, exam.examName );
        
        self.getExamQuestions();
        
        doTabClick( 3 );
        
    };
    
    // instructor DOM elements
    self.getQuestion = function( questionId ) {
        return self.questions.find( function( elem ) {
            return elem.questionId == questionId;       // newly entered exams are ints
        });
    };
    
    self.currentQuestion = function() {
        return self.getQuestion( self.currentQuestionId );
    };
    
    self.getExam = function( examId ) {
        return self.exams.find( function( elem ) {
            return elem.examId === examId;
        });
    };
    
    self.currentExam = function() {
        var currentExam = null;
        var examId = self.currentExamId;
        if ( examId !== null ) {
            currentExam = self.getExam( examId );
        }
        return currentExam;
    };
    
    self.createQuestionElement = function( question, select ) {

        var tr = document.createElement( "tr" );
        
        if ( select !== undefined && select !== null && select ) {
            createCheckbox( question.questionId, question.questionId, false, tr );
        }

        createLabel( null, question.functionName, tr );

        createLabel( null, question.question, tr );

        createLabel( null, self.getFunctionSignature( question ), tr );

        createLabel( null, self.getDifficulty( question.difficulty ), tr );
        
        createLabel( null, boolToString( question.hasIf ), tr );

        createLabel( null, boolToString( question.hasWhile ), tr );
        
        createLabel( null, boolToString( question.hasFor ), tr );
        
        createLabel( null, boolToString( question.hasRecursion ), tr );
        
        createAnchor( "#", question.questionId, "Test Cases", self.manageTestCases, tr );

        return tr;

    };
    
    self.createExamQuestionScoreElement = function( score ) {
        
        console.debug( score );
        
        var tr = document.createElement( "tr" );
        
        tr.id = score.questionId;
        
        createLabel( null, score.question, tr );
        
        createLabel( null, score.answer, tr );
        
        createLabel( null, self.getDifficulty( score.difficulty ), tr );
        
        var scoreElem = createInput( score.questionId, "text", score.questionId, score.score, tr );
        
        scoreElem.className += " score";
        
        createLabel( null, score.possible, tr );
        
        createAnchor( "#", score.questionId, "Feedback", self.getFeedback, tr );
        
        return tr;
        
    };
    
    self.createExamFeedbackElement = function( examFeedback ) {
        
        var tr = document.createElement( "tr" );
        
        createLabel( null, examFeedback.description, tr );
        
        var correct = examFeedback.correct == "1";
        
        var correctLabel = createLabel( null, correct ? "yes" : "no", tr );
        
        correctLabel.className += correct ?  " feedback-correct" : " feedback-incorrect";
        
        var result = '( ' + examFeedback.score + ' / ' + examFeedback.possible + ' )';
        
        createLabel( null, result, tr );
        
        return tr;
        
    };
    
    self.createExamQuestionElement = function( examQuestion ) {
    
        var funcName = self.getQuestion( examQuestion.questionId ).functionName;
        var elem = createAnchor( "#", examQuestion.questionId, funcName, null );

        return createTableRow( elem );

    };
    
    self.createQuestionOptionElement = function( question ) {
      
        return createOption( question.questionId, question.functionName );
        
    };

    /**
     * Creates an exam DOM element suitable for insertion and returns it
     * @param {type} exam
     * @returns {Element|createExamElement.tr}
     */
    self.createExamElement = function( exam  ) {

        var tr = document.createElement( "tr" );

        createLabel( null, exam.examName, tr );
        
        createAnchor( "#", exam.examId, "Manage Questions", self.manageExamQuestions, tr );

        createAnchor( "#", exam.examId, "Score", self.scoreExam, tr );
        
        var id = { examId: exam.examId, ucid: exam.ucid };
        
        createAnchor( "#", JSON.stringify( id ), "Preview Scores", self.previewScores, tr );

        return tr;

    };

    self.createTestcaseElement = function( testCase ) {

        var tr = document.createElement( "tr" );

        createLabel( testCase.testCaseId, self.createTestcaseSignature( testCase ), tr );

        return tr;

    };

    self.createTestcaseSignature = function( testCase ) {

        var args = [ testCase.argument1, testCase.argument2, testCase.argument3, testCase.argument4 ];
        var sig = "";
        
        var question = self.getQuestion( testCase.questionId );

        args.forEach( function( arg ) {
           if ( arg !== null && arg.length > 0 ) {
               if ( sig !== "" ) {
                   sig = sig + ", ";
               }
               sig = sig + arg;
           } 
        });

        return question.functionName + "( " + sig + " ) == " + testCase.returnValue;

    };
    
    self.getFunctionSignature = function( question ) {

        var parms = [ question.argument1, question.argument2, question.argument3, question.argument4 ];
        var sig = "";

        var i = 1;

        parms.forEach( function( parm ) {
           if ( parm !== null && parm.length > 0 ) {
               if ( sig !== "" ) {
                   sig = sig + ", ";
               }
               sig = sig + parm + " arg" + i;
               i++;
           } 
        });

        return  question.returnType + " " + question.functionName +  "( " + sig + " )";

    };
    
    self.getDifficulty = function( difficulty ) {
      
        var diffs = [ "", "Easy", "Medium", "Hard" ];

        var diff = diffs[ difficulty ];

        return diff;
        
    };

    self.getQuestionTraits = function( question, difficulty ) {

        if ( isEmpty( difficulty ) ) {
            difficulty = true;
        }

        var sig = "";

        var has = [ "If", "While", "For", "Recursion" ];

        has.forEach( function( h ) {
            var propName = "has" + h;
            var value = isTrue( question[ propName ] );
            if ( value !== false ) {
                if ( sig !== "" ) {
                    sig = sig + ", ";
                }
                sig = sig + h.toLowerCase();
            }
        });

        if ( difficulty ) {

            var diff = self.getDifficulty( question.difficulty );

            if ( sig !== "" ) {
                sig = sig + ", ";
            }

            sig = sig + diff;

        }

        return sig;

    };
    
    function stringFilter( text, substring ) {
        return contains( text, substring );
    }
    
    function boolFilter( questionFlag, filterFlag ) {
        var result = true;
        if ( filterFlag !== null && filterFlag ) {
            result = questionFlag != 0;
        }
        return result;
    }
    
    function intFilter( questionValue, filterValue ) {
        var result = true;
        if ( !isEmptyString( filterValue ) ) {
            result = questionValue === filterValue;
        }
        return result;
    }
    
    self.filterQuestions = function () {
        
        var filter = formNameToObjectById( self.questionFilterFormId );
        
        var filteredQuestions = self.questions.filter( function( question ) {
            
            var result = true;
            
            if ( filter !== null ) {
            
                result = result && stringFilter( question.question, filter.textFilter );

                result = result && stringFilter( question.functionName, filter.funcNameFilter );

                result = result && intFilter( question.difficulty, filter.difficultyFilter );

                result = result && boolFilter( question.hasIf, filter.hasIfFilter );
                
                result = result && boolFilter( question.hasWhile, filter.hasWhileFilter );
                
                result = result && boolFilter( question.hasFor, filter.hasForFilter );
                
                result = result && boolFilter( question.hasRecursion, filter.hasRecursionFilter );
            
            }
            
            return result;
            
        });
        
        var found = filteredQuestions.length > 0;
        
        createAndReplaceElementsById( self.filteredQuestionListId, "tr", filteredQuestions, 
            function( question ) { 
                return self.createQuestionElement( question, true ); 
            } );
            
        displayById( self.filteredQuestionListEmptyId, !found );
        displayById( self.filteredQuestionListHeaderId, found );
        
    };
    
    self.addQuestionsToExam = function() {
        
        // pull out the input fields and create a request object
        var object = formToObjectById( self.filteredQuestionFormId );
        
        var questionIds = [];
        
        for ( var prop in object ) {
            // grab the checked boxes
            if ( object[ prop ] ) {
                // only if they are not already a part of the examQuestionList
                if ( self.examquestions.findIndex( function( elem ) {
                    return elem.questionId === prop;
                }) === -1 ) {
                    questionIds.push( prop );
                }
            }
        }

        var data = {
            examId: self.currentExamId,
            questionIds: questionIds
        };
        
        var adding = questionIds.length > 0;

        if ( adding ) {

            var success = function( results ) {

                stopActivity();

                if ( results.success ) {
                    
                    checkAllByFormId( self.filteredQuestionFormId, 'checkbox', false );
                    
                    data.questionIds.forEach( function( questionId ) {
                        var newData = {
                            examId: self.currentExamId,
                            questionId: questionId
                        };
                        self.examquestions.push( newData );
                        createAndAddElementById( newData, self.createExamQuestionElement, self.examQuestionListId );
                    } );
                    
                    displayById( self.examQuestionListEmptyId, false );
                    displayById( self.examQuestionListHeaderId, true );
                    
                }

            };

            post( "../addExamQuestions.php", data, success, self.onPostError );
        
        }

    };
    
}