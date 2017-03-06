/* 
 *     File:        js/student.js
 *     Author:      Bob Provencher
 *     Created:     Mar 5, 2017
 *     Description: student page code
 */

var currentExamId = null;
var currentExamTestId = null;
var currentAnswerId = null;

var exams  = [];
var grades = [];
var answers = [];
var feedback = [];
var questions = [];

function createStudentExamElement( exam, onclick ) {
    
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
    elem.innerHTML = "Take";
    elem.onclick = takeExam;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = exam.examId;
    elem.innerHTML = "Show Score";
    elem.onclick = showScore;
    
    return tr;
    
}

function createStudentExamGradeElement( grade, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = grade.examName;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = grade.examId;
    elem.innerHTML = grade.grade;
    elem.onclick = onclick;
    
    return tr;
    
}

function createAnswerElement( answer, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = answer.question;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = answer.answer;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = answer.questionId;
    elem.innerHTML = answer.score;
    elem.onclick = onclick;
    
    return tr;
    
}

function createFeedbackElement( feedback, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = feedback.description;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = feedback.correct == true ? "YES" : "NO";
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = feedback.score;
    
    return tr;
    
}

function createExamQuestionElement( question, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = question.question;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "label" );
    td.appendChild( elem );
    elem.innerHTML = getQuestionTraits( question, false );
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "textarea" );
    elem.cols = 80;
    elem.rows = 10;
    elem.id = question.questionId;
    td.appendChild( elem );
    
    return tr;
    
}

function takeExam() {
    currentExamTestId = this.id;
    getExamQuestions( currentExamTestId );
    displayById( "show-exams", false );
    displayById( "take-test", true );
}

function saveTest() {
    
    var form = document.getElementById( "test" );
    
    var data = {
        ucid: studentUcid,
        examId: currentExamTestId,
        answers: []
    };
    
    for ( var i = 0; i < form.elements.length; i++ ) {
        var elem = form.elements[ i ];
        if ( elem.type === 'textarea' ) {
            var a = {
                questionId: elem.id,
                answer: elem.value
            }
            data.answers.push( a );
        } 
    }
    
    var success = function( results ) {
        if ( results.success ) {
            showError( "test-message", "Test Saved" );
        }
        else {
            showError( "test-message", "Error Saving Test" );
        }
    };

    post( "../addExamQuestionAnswers.php", data, success, onPostError );


}

function showScore() {
    currentExamId = this.id;
    getStudentExamGrade();
    displayById( "show-exams", true );
    displayById( "take-test", false );
}

function selectExam() {
    currentExamId = this.id;
    getStudentExamGrade();
}

function getAllExams() {
    
    displayById( "show-exams", true );
    displayById( "take-test", false );

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-exam-list-empty-id", !found, "No exams found" );
        exams = results;
        createAndReplaceElementsById( "cs490-exam-list-id", "tr", results, selectExam, createStudentExamElement );
    };

    post( "../allExams.php", null, success, onPostError );

}

function getExam( examId ) {
    return exams.find( function( exam ) {
        return exam.examId === examId;
    });
}

function getStudentExamGrade() {
    
    var data = {
        ucid: studentUcid,
        examId: currentExamId
    };
    
    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-grade-list-empty-id", !found, "No grades found" );
        grades = results;
        createAndReplaceElementsById( "cs490-grade-list-id", "tr", results, selectExamGrade, createStudentExamGradeElement );
        if ( found ) {
            selectExamGrade();
        }
    }
    
    post( "../studentExamGrade.php", data, success, onPostError )
    
}

function selectExamGrade() {
    getExamAnswers();
}

function getExamAnswers() {
    
    var data = {
        ucid: studentUcid,
        examId: currentExamId
    };
    
    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-answer-list-empty-id", !found, "No answers found" );
        answers = results;
        createAndReplaceElementsById( "cs490-answer-list-id", "tr", results, selectAnswer, createAnswerElement );
    }
    
    post( "../studentExamQuestionScores.php", data, success, onPostError )
    
}

function selectAnswer() {
    currentAnswerId = this.id;
    getQuestionFeedback();
}

function getQuestionFeedback() {
    
    var data = {
        ucid: studentUcid,
        examId: currentExamId,
        questionId: currentAnswerId
    };
    
    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-feedback-list-empty-id", !found, "No feedback found" );
        feedback = results;
        createAndReplaceElementsById( "cs490-feedback-list-id", "tr", results, null, createFeedbackElement );
    }
    
    post( "../studentExamQuestionFeedback.php", data, success, onPostError )
    
}

function getExamQuestions( examId ) {

    var data = {
        examId: examId
    };

    var success = function( results ) {
        var found = results.length > 0;
        displayLabelById( "cs490-question-list-empty-id", !found, "No questions found" );
        questions = results;
        createAndReplaceElementsById( "cs490-question-list-id", "tr", results, null, createExamQuestionElement );
    };

    post( "../examQuestions.php", data, success, onPostError );
    
}
