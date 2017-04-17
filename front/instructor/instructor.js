/* 
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

    // current data
    self.questions = [];
    self.exams = [];
    self.testcases = [];
    self.examquestions = [];
    self.feedback = [];
    
    self.lastExamFeedback = null;
    
    // ids
    self.questionListEmptyId        = "cs490-question-list-empty-id";
    self.questionListHeaderId       = "cs490-question-list-header-id";
    self.questionListId             = "cs490-question-list-id";
    self.questionFormId             = "cs490-question-form-id";
    
    self.testCaseQuestionId         = "cs490-testcase-question-id";
    self.testCaseQuestionSignatureId = "cs490-testcase-question-signature-id";
    self.testCaseListEmptyId        = "cs490-testcase-list-empty-id";
    self.testCaseListHeaderId       = "cs490-testcase-list-header-id";
    self.testCaseListId             = "cs490-testcase-list-id";
    self.testCaseFormId             = "cs490-testcase-form-id";
     
    self.examListEmptyId            = "cs490-exam-list-empty-id";
    self.examListHeaderId           = "cs490-exam-list-header-id";
    self.examListId                 = "cs490-exam-list-id";
    self.examFormId                 = "cs490-exam-form-id";
    
    self.examQuestionId             = "cs490-examquestion-id";
    self.examQuestionListEmptyId    = "cs490-examquestion-list-empty-id";
    self.examQuestionListHeaderId   = "cs490-examquestion-list-header-id";
    self.examQuestionListId         = "cs490-examquestion-list-id";
    self.examQuestionFormId         = "cs490-examquestion-form-id";
    
    self.examFeedbackId             = "cs490-examfeedback-id";
    self.examFeedbackListId         = "cs490-examfeedback-list-id";
    self.examFeedbackListEmptyId    = "cs490-examfeedback-list-empty-id";
    self.examFeedbackListHeaderId   = "cs490-examfeedback-list-header-id";
    self.examFeedbackFornId         = "cs490-examfeedback-form-id";
    
    // data retrieval methods
    self.getQuestions = function() {

        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.questions = results;
            createAndReplaceElementsById( self.questionListId, "tr", results, 
                function( question ) { 
                    return self.createQuestionElement( question, true ); 
                } );
            displayById( self.questionListEmptyId, !found );
            displayById( self.questionListHeaderId, found );
            createAndReplaceElementsById( "questions-list", "option", results, self.createQuestionOptionElement );
        };

        post( "../questions.php", null, success, self.onPostError );

    };

    self.getTestCases = function() {

        var data = { 
            questionId: self.currentQuestionId 
        };

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

    self.getExamQuestions = function() {

        var data = {
            examId: self.currentExamId
        };

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
    
    self.getExamFeedback = function() {

        var data = {
            examId: self.currentExamId
        };

        var success = function( results ) {
            stopActivity();
            var found = results.length > 0;
            self.feedback = results;
            createAndReplaceElementsById( self.examFeedbackListId, "tr", results, self.createExamFeedbackElement );
            displayById( self.examFeedbackListEmptyId, !found );
            displayById( self.examFeedbackListHeaderId, found );
        };

        post( "../studentExamFeedback.php", data, success, onPostError );

    };

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
                //console.log( results );

                if ( results.success ) {
                    object.questionId = results.questionId;
                    self.questions.push( object );
                    createAndAddElementById( object, self.createQuestionElement, self.questionListId );
                    displayById( self.questionListEmptyId, false );
                    displayById( self.questionListHeaderId, true );
                    createAndAddElementById( object, self.createQuestionOptionElement, "questions-list" );
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
    
    // not implemented
    self.deleteQuestion = function() {
        
        var questionId = this.id;

        var data = {
            questionId: questionId
        };

        var success = function( results ) {

            stopActivity();
            
            if ( results.success ) {
            }

        };

        //post( "../deleteQuestion.php", data, success, self.onPostError );
        
    };

    self.scoreExam = function() {

        self.currentExamId = this.id;

        var data = {
            examId: self.currentExamId
        };

        var success = function( results ) {

            if ( results.success ) {
                showError( "examName-error", "Exam Scored!", 3000, 
                function () {
                    self.getExamFeedback();
                    doTabClick( 4 );
                } );
            }
            else {
                showError( "examName-error", "Sorry, there was an error scoring the exam.", 3000 );
            }

        };

        post( "../releaseScores.php", data, success, self.onPostError );

    };
    
    self.previewScores = function () {
        
        self.currentExamId = this.id;
        
        self.getExamFeedback();
        
        doTabClick( 4 );
        
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
        
        var exam = self.getExam( self.currentExamId );
        
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
    
    self.getExam = function( examId ) {
        return self.exams.find( function( elem ) {
            return elem.examId === examId;
        });
    };

    self.createQuestionElement = function( question, deleteLink ) {

        var tr = document.createElement( "tr" );

        createLabel( null, question.functionName, tr );

        createLabel( null, question.question, tr );

        createLabel( null, self.getFunctionSignature( question ), tr );

        createLabel( null, self.getDifficulty( question.difficulty ), tr );
        
        createLabel( null, boolToString( question.hasIf ), tr );

        createLabel( null, boolToString( question.hasWhile ), tr );
        
        createLabel( null, boolToString( question.hasFor ), tr );
        
        createLabel( null, boolToString( question.hasRecursion ), tr );
        
        createAnchor( "#", question.questionId, "Test Cases", self.manageTestCases, tr );

        if ( deleteLink ) {
            // TODO: not implemented
            //createAnchor( "#", question.questionId, "Delete", self.deleteQuestion, tr );
        }

        return tr;

    };
    
    self.createExamFeedbackElement = function( examFeedback ) {
        
        var tr = document.createElement( "tr" );
        
        var question = examFeedback.question;
        var answer = examFeedback.answer;
        
        if ( self.lastExamFeedback !== null && question === self.lastExamFeedback.question ) {
            question = null;
        }
        
        if ( self.lastExamFeedback !== null && answer === self.lastExamFeedback.answer ) {
            answer = null;
        }
        
        createLabel( null, question, tr );
        
        createLabel( null, answer, tr );
        
        createLabel( null, examFeedback.description, tr );
        
        createCheckbox( examFeedback.feedbackId, examFeedback.feedbackId, examFeedback.correct == "1", tr );
        
        var score = createInput( examFeedback.feedbackId, "text", examFeedback.feedbackId, examFeedback.score, tr );
        
        score.className += " score";
        
        createLabel( null, examFeedback.possible, tr );
        
        self.lastExamFeedback = examFeedback;
        
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
        
        createAnchor( "#", exam.examId, "Preview Scores", self.previewScores, tr );

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
      
        var diffs = [ "Easy", "Medium", "Hard" ];

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

}