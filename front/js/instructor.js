/* 
 *     File:        js/instructor.js
 *     Author:      Bob Provencher
 *     Created:     Mar 5, 2017
 *     Description: instructor page code
 */

var currentExamId = null;
var currentQuestionId = null;

var questions = [];
var exams = [];
var testcases = [];
var examquestions = [];

function addQuestion() {

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
                questions.push( object );
                createAndAddElementById( object, selectQuestion, createQuestionElement, "cs490-question-list-id" );
            }

        };

        post( "../addQuestion.php", object, success, onPostError );

    }

}

function addExam() {

    // pull out the input fields and create a request object
    var object = formToObjectById( "cs490-exam-form-id" );
    
    var verified = verifyNotBlank ( object.examName, "examName-error", "Exam name cannot be blank" );

    if ( verified ) {

        object.ownerId = instructorUcid;

        var success = function( results ) {

            if ( results.success ) {
                object.examId = results.examId;
                exams.push( object );
                createAndAddElementById( object, selectExam, createExamElement, "cs490-exam-list-id" );
            }

        };

        post( "../addExam.php", object, success, onPostError );

    }

}

function addTestCase() {

    var object = formToObjectById( "cs490-testcase-form-id" );

    object.questionId = currentQuestionId;

    if ( object.questionId !== null ) {

        var fields = [
            "argument1", "returnValue" 
        ];

        var verified = verifyFieldsNotBlank( object, fields );

        if ( verified ) {

            var success = function( results ) {

                if ( results.success ) {
                    object.testCaseId = results.testCaseId;
                    testcases.push( object );
                    displayLabelById( "cs490-testcase-list-empty-id", false, null );
                    createAndAddElementById( object, null, createTestcaseElement, "cs490-testcase-list-id" );
                }

            }

            post( "../addTestCase.php", object, success, onPostError );

        }

    }
    else {

        showError( "testcase-error", "Please choose a question", 3000 );

    }

}

function addToExam() {

    var questionId = this.id;

    var data = {
        examId: currentExamId,
        questionId: questionId
    };

    var success = function( results ) {

        if ( results.success ) {
            displayLabelById( "cs490-examquestion-list-empty-id", false, null );
            examquestions.push( data );
            createAndAddElementById( data, null, createExamQuestionElement, "cs490-examquestion-list-id" );
        }

    };

    post( "../addExamQuestion.php", data, success, onPostError );

}

function releaseScores() {
    
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

    post( "../releaseScores.php", data, success, onPostError );

}

function getExams( ownerUcid ) {

    // the user
    var data = {
        ownerId: ownerUcid
    };

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-exam-list-empty-id", !found, "No exams found" );
        exams = results;
        createAndReplaceElementsById( "cs490-exam-list-id", "tr", results, selectExam, createExamElement );
    };

    post( "../exams.php", data, success, onPostError );

}

function getExamQuestions( examId ) {

    var data = {
        examId: examId
    };

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-examquestion-list-empty-id", !found, "No questions found" );
        examquestions = results;
        createAndReplaceElementsById( "cs490-examquestion-list-id", "tr", results, null, createExamQuestionElement );
    };

    post( "../examQuestions.php", data, success, onPostError );
}

function getQuestions() {

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-question-list-empty-id", !found, "No questions found" );
        questions = results;
        createAndReplaceElementsById( "cs490-question-list-id", "tr", results, selectQuestion, createQuestionElement );
    };

    post( "../questions.php", null, success, onPostError );

}

function getTestCases( questionId ) {

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-testcase-list-empty-id", !found, "No test cases found" );
        testcases = results;
        createAndReplaceElementsById( "cs490-testcase-list-id", "tr", results, selectQuestion, createTestcaseElement );
    };

    var data = { questionId: questionId };

    post( "../testCases.php", data, success, onPostError );

}

function selectExam() {
    currentExamId = this.id;
    getExamQuestions( currentExamId );
}

function selectQuestion() {
    currentQuestionId = this.id;
    getTestCases( currentQuestionId );
}

/**
 * Creates an exam DOM element suitable for insertion and returns it
 * @param {type} exam
 * @param {type} onclick
 * @returns {Element|createExamElement.tr}
 */
function createExamElement( exam, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = exam.examId;
    elem.innerHTML = exam.examName;
    elem.onclick = onclick;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = exam.examId;
    elem.innerHTML = "Release Scores";
    elem.onclick = releaseScores;
    
    return tr;
    
}
