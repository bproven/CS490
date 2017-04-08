/* 
 *     File:        instructor/instructor.js
 *     Author:      Bob Provencher
 *     Created:     Mar 5, 2017
 *     Description: instructor page code
 */

function Instructor( instructorUcid, onPostError ) {
    
    var self = this;

    // data
    
    self.instructorUcid = instructorUcid;
    self.onPostError = isEmpty( onPostError ) ? function( request ) {} : onPostError;
    
    self.currentExamId = null;
    self.currentQuestionId = null;

    self.questions = [];
    self.exams = [];
    self.testcases = [];
    self.examquestions = [];
    
    // data retrieval
    
    self.getExams = function() {

        // the user
        var data = {
            ownerId: self.instructorUcid
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-exam-list-empty-id", !found, "No exams found" );
            self.exams = results;
            createAndReplaceElementsById( "cs490-exam-list-id", "tr", results, self.createExamElement );
        };

        post( "../exams.php", data, success, self.onPostError );

    };

    self.getExamQuestions = function() {

        var data = {
            examId: self.currentExamId
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-examquestion-list-empty-id", !found, "No questions found" );
            self.examquestions = results;
            createAndReplaceElementsById( "cs490-examquestion-list-id", "tr", results, self.createExamQuestionElement );
        };

        post( "../examQuestions.php", data, success, self.onPostError );
        
    };

    self.getQuestions = function() {

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-question-list-empty-id", !found, "No questions found" );
            self.questions = results;
            createAndReplaceElementsById( "cs490-question-list-id", "tr", results, self.createQuestionElement );
        };

        post( "../questions.php", null, success, self.onPostError );

    };

    self.getTestCases = function() {

        var data = { 
            questionId: self.currentQuestionId 
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-testcase-list-empty-id", !found, "No test cases found" );
            self.testcases = results;
            createAndReplaceElementsById( "cs490-testcase-list-id", "tr", results, self.createTestcaseElement );
        };

        post( "../testCases.php", data, success, self.onPostError );

    };
    
    // UI event handlers

    self.selectExam = function() {
        self.currentExamId = this.id;
        self.getExamQuestions( self.currentExamId );
    };

    self.selectQuestion = function() {
        self.currentQuestionId = this.id;
        self.getTestCases( self.currentQuestionId );
    };

    self.addQuestion = function() {

        // pull out the input fields and create a request object
        var object = formToObjectById( "cs490-question-form-id" );

        var fields = [
            "question", "argument1", "returnType", 
            "difficulty", "functionName", 
            "hasIf", "hasWhile", "hasFor", "hasRecursion"
        ];

        var verified = verifyFieldsNotBlank( object, fields );

        if ( verified ) {

            var success = function( results ) {

                //console.log( results );

                if ( results.success ) {
                    object.questionId = results.questionId;
                    self.questions.push( object );
                    createAndAddElementById( object, self.createQuestionElement, "cs490-question-list-id" );
                }

            };

            post( "../addQuestion.php", object, success, self.onPostError );

        }

    };

    self.addExam = function() {

        // pull out the input fields and create a request object
        var object = formToObjectById( "cs490-exam-form-id" );

        var verified = verifyNotBlank ( object.examName, "examName-error", "Exam name cannot be blank" );

        if ( verified ) {

            object.ownerId = instructorUcid;

            var success = function( results ) {

                if ( results.success ) {
                    object.examId = results.examId;
                    self.exams.push( object );
                    createAndAddElementById( object, self.createExamElement, "cs490-exam-list-id" );
                }

            };

            post( "../addExam.php", object, success, self.onPostError );

        }

    };

    self.addTestCase = function() {

        var object = formToObjectById( "cs490-testcase-form-id" );

        object.questionId = self.currentQuestionId;

        if ( object.questionId !== null ) {

            var fields = [
                "argument1", "returnValue" 
            ];

            var verified = verifyFieldsNotBlank( object, fields );

            if ( verified ) {

                var success = function( results ) {

                    if ( results.success ) {
                        object.testCaseId = results.testCaseId;
                        self.testcases.push( object );
                        displayLabelById( "cs490-testcase-list-empty-id", false, null );
                        createAndAddElementById( object, self.createTestcaseElement, "cs490-testcase-list-id" );
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

        var questionId = this.id;

        var data = {
            examId: self.currentExamId,
            questionId: questionId
        };

        var success = function( results ) {

            if ( results.success ) {
                displayLabelById( "cs490-examquestion-list-empty-id", false, null );
                self.examquestions.push( data );
                createAndAddElementById( data, self.createExamQuestionElement, "cs490-examquestion-list-id" );
            }

        };

        post( "../addExamQuestion.php", data, success, self.onPostError );

    };

    self.releaseScores = function() {

        var examId = this.id;

        var data = {
            examId: examId
        };

        var success = function( results ) {

            if ( results.success ) {
                showError( "examName-error", "Scores released!", 3000 );
            }
            else {
                showError( "examName-error", "Sorry, there was an error releasing scores.", 3000 );
            }

        };

        post( "../releaseScores.php", data, success, self.onPostError );

    };
    
    // instructor DOM elements
    
    self.getQuestion = function( questionId ) {
        return self.questions.find( function( elem ) {
            return elem.questionId === questionId;
        });
    };

    self.createQuestionElement = function( question ) {

        var elem = createAnchor( "#", question.questionId, question.functionName, self.selectQuestion );

        var tr = createTableRow( elem );

        createLabel( null, question.question, tr );

        createLabel( null, self.getFunctionSignature( question ), tr );

        createLabel( null, self.getQuestionTraits( question, true ), tr );

        createAnchor( "#", question.questionId, "Add to Exam", self.addToExam, tr );

        return tr;

    };
    
    self.createExamQuestionElement = function( examQuestion ) {
    
        var funcName = self.getQuestion( examQuestion.questionId ).functionName;
        var elem = createAnchor( "#", examQuestion.questionId, funcName, null );

        return createTableRow( elem );

    };

    /**
     * Creates an exam DOM element suitable for insertion and returns it
     * @param {type} exam
     * @returns {Element|createExamElement.tr}
     */
    self.createExamElement = function( exam  ) {

        var tr = document.createElement( "tr" );

        createAnchor( "#", exam.examId, exam.examName, self.selectExam, tr );

        createAnchor( "#", exam.examId, "Release Scores", self.releaseScores );

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

        args.forEach( function( arg ) {
           if ( arg !== null && arg.length > 0 ) {
               if ( sig !== "" ) {
                   sig = sig + ", ";
               }
               sig = sig + arg;
           } 
        });

        return  testCase.returnValue + " == function( " + sig + " )";

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

    self.getQuestionTraits = function( question, difficulty ) {

        if ( isEmpty( difficulty ) ) {
            difficulty = true;
        }

        var sig = "";

        var has = [ "If", "While", "For", "Recursion" ];

        has.forEach( function( h ) {
            var propName = "has" + h;
            var value = question[ propName ];
            if ( value !== false ) {
                if ( sig !== "" ) {
                    sig = sig + ", ";
                }
                sig = sig + h.toLowerCase();
            }
        });

        if ( difficulty ) {

            var diffs = [ "Easy", "Medium", "Hard" ];

            var diff = diffs[ question.difficulty ];

            if ( sig !== "" ) {
                sig = sig + ", ";
            }

            sig = sig + diff;

        }

        return sig;

    };

}