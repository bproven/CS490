/* 
 *     File:        student/student.js
 *     Author:      Bob Provencher
 *     Created:     Mar 5, 2017
 *     Description: student view model
 */

function Student( studentUcid, onPostError ) {
    
    var self = this;
    
    // data
    self.studentUcid = studentUcid;
    self.onPostError = isEmpty( onPostError ) ? function( request ) {} : onPostError;
    
    self.currentExamId = null;
    self.currentExamTestId = null;
    self.currentAnswerId = null;

    self.exams  = [];
    self.grades = [];
    self.answers = [];
    self.feedback = [];
    self.questions = [];
    
    // data retrieval
    self.getExam = function( examId ) {
        return self.exams.find( function( exam ) {
            return exam.examId === examId;
        });
    };

    self.getAllExams = function() {

        displayById( "show-exams", true );
        displayById( "take-test", false );

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-exam-list-empty-id", !found, "No exams found" );
            self.exams = results;
            createAndReplaceElementsById( "cs490-exam-list-id", "tr", results, self.createExamElement );
        };

        post( "../allExams.php", null, success, self.onPostError );

    };

    self.getStudentExamGrade = function() {
    
        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-grade-list-empty-id", !found, "No grades found" );
            self.grades = results;
            createAndReplaceElementsById( "cs490-grade-list-id", "tr", results, self.createExamGradeElement );
            if ( found ) {
                self.selectExamGrade();
            }
        };
    
        post( "../studentExamGrade.php", data, success, self.onPostError );
    
    };

    self.getExamAnswers = function() {

        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-answer-list-empty-id", !found, "No answers found" );
            self.answers = results;
            createAndReplaceElementsById( "cs490-answer-list-id", "tr", results, self.createAnswerElement );
        };

        post( "../studentExamQuestionScores.php", data, success, self.onPostError );

    };

    self.getQuestionFeedback = function() {

        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId,
            questionId: self.currentAnswerId
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-feedback-list-empty-id", !found, "No feedback found" );
            self.feedback = results;
            createAndReplaceElementsById( "cs490-feedback-list-id", "tr", results, self.createFeedbackElement );
        };

        post( "../studentExamQuestionFeedback.php", data, success, onPostError );

    };

    self.getExamQuestions = function() {

        var data = {
            examId: self.currentExamTestId
        };

        var success = function( results ) {
            var found = results.length > 0;
            displayLabelById( "cs490-question-list-empty-id", !found, "No questions found" );
            self.questions = results;
            createAndReplaceElementsById( "cs490-question-list-id", "tr", results, self.createExamQuestionElement );
        };

        post( "../examQuestions.php", data, success, onPostError );
    
    };
    
    // UI event handlers

    self.takeExam = function() {
        self.currentExamTestId = this.id;
        self.getExamQuestions();
        displayById( "show-exams", false );
        displayById( "take-test", true );
    };

    self.saveTest = function() {
    
        var form = document.getElementById( "test" );

        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamTestId,
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

        post( "../addExamQuestionAnswers.php", data, success, self.onPostError );

    };

    self.showScore = function() {
        self.currentExamId = this.id;
        self.getStudentExamGrade();
        displayById( "show-exams", true );
        displayById( "take-test", false );
    };

    self.selectExam = function() {
        self.currentExamId = this.id;
        self.getStudentExamGrade();
        displayById( "show-exams", true );
        displayById( "take-test", false );
    };

    self.selectExamGrade = function() {
        self.getExamAnswers();
    };

    self.selectAnswer = function() {
        self.currentAnswerId = this.id;
        self.getQuestionFeedback();
    };
    
    // student DOM elements
    
    self.createExamQuestionElement = function( question ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, question.question, tr );

        createLabel( null, getQuestionTraits( question, false ), tr );

        createTextArea( question.questionId, 80, 10, tr );
    
        return tr;
    
    };
    
    self.createExamGradeElement = function( grade ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, grade.examName, tr );

        createAnchor( "#", grade.examId, grade.score, self.selectExamGrade, tr );

        return tr;
    
    };

    self.createExamElement = function( exam ) {

        var tr = document.createElement( "tr" );

        createAnchor( "#", exam.examId, exam.examName, self.selectExam, tr );

        createAnchor( "#", exam.examId, "Take", self.takeExam, tr );

        createAnchor( "#", exam.examId, "Show Score", self.showExam, tr );

        return tr;

    };
    
    self.createFeedbackElement = function( feedback ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, feedback.description, tr );

        createLabel( null, feedback.correct ? "YES" : "NO", tr );

        createLabel( null, feedback.score, tr );

        return tr;

    };

    self.createAnswerElement = function( answer ) {

        var tr = document.createElement( "tr" );

        createLabel( null, answer.question, tr );

        createLabel( null, answer.answer, tr );
        
        createAnchor( "#", answer.questionId, answer.score, self.selectAnswer, tr );

        return tr;

    };
    
}


