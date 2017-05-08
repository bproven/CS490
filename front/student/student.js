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
    
    // currently selected
    self.currentExamId = null;
    self.currentExamTestId = null;
    self.currentAnswerId = null;

    // current data
    self.exams  = [];
    self.grades = [];
    self.answers = [];
    self.feedback = [];
    self.questions = [];
    
    makeIds( self, "exam" );
    makeIds( self, "grade" );
    makeIds( self, "answer" );
    makeIds( self, "feedback" );
    makeIds( self, "question" );
    
    // ids
//    self.examListEmptyId            = "cs490-exam-list-empty-id";
//    self.examListHeaderId           = "cs490-exam-list-header-id";
//    self.examListId                 = "cs490-exam-list-id";
//    
//    self.examGradeListEmptyId       = "cs490-grade-list-empty-id";
//    self.examGradeListHeaderId      = "cs490-grade-list-header-id";
//    self.examGradeListId            = "cs490-grade-list-id";
//    
//    self.examAnswerListEmptyId      = "cs490-answer-list-empty-id";
//    self.examAnswerListHeaderId     = "cs490-answer-list-header-id";
//    self.examAnswerListId           = "cs490-answer-list-id";
//    
//    self.examFeedbackListEmptyId    = "cs490-feedback-list-empty-id";
//    self.examFeedbackListHeaderId   = "cs490-feedback-list-header-id";
//    self.examFeedbackListId         = "cs490-feedback-list-id";
//    
//    self.examQuestionListEmptyId    = "cs490-question-list-empty-id";
//    self.examQuestionListHeaderId   = "cs490-question-list-header-id";
//    self.examQuestionListId         = "cs490-question-list-id";
    
    // data retrieval methods
    self.getAllExams = function() {

        //displayById( "show-exams", true );
        //displayById( "take-test", false );

        displayById( self.examListEmptyId, false );
        displayById( self.examListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.exams = results;
            createAndReplaceElementsById( self.examListId, "tr", results, self.createExamElement );
            displayById( self.examListEmptyId, !found );
            displayById( self.examListHeaderId, found );
        };

        post( "../allExams.php", null, success, self.onPostError );

    };

    self.getStudentExamGrade = function() {
    
        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId
        };

        displayById( self.gradeListEmptyId, false );
        displayById( self.gradeListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.grades = results;
            createAndReplaceElementsById( self.gradeListId, "tr", results, self.createExamGradeElement );
            displayById( self.gradeListEmptyId, !found );
            displayById( self.gradeListHeaderId, found );
            if ( found ) {
                //self.selectExamGrade();
            }
        };
    
        post( "../studentExamGrade.php", data, success, self.onPostError );
    
    };

    self.getExamQuestionScores = function() {

        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId
        };

        displayById( self.answerListEmptyId, false );
        displayById( self.answerListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.answers = results;
            createAndReplaceElementsById( self.answerListId, "tr", results, self.createAnswerElement );
            displayById( self.answerListEmptyId, !found );
            displayById( self.answerListHeaderId, found );
        };

        post( "../studentExamQuestionScores.php", data, success, self.onPostError );

    };

    self.getQuestionFeedback = function() {

        var data = {
            ucid: self.studentUcid,
            examId: self.currentExamId,
            questionId: self.currentAnswerId
        };

        displayById( self.feedbackListEmptyId, false );
        displayById( self.feedbackListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.feedback = results;
            createAndReplaceElementsById( self.feedbackListId, "tr", results, self.createFeedbackElement );
            displayById( self.feedbackListEmptyId, !found );
            displayById( self.feedbackListHeaderId, found );
        };

        post( "../studentExamQuestionFeedback.php", data, success, onPostError );

    };

    self.getExamQuestions = function() {

        var data = {
            examId: self.currentExamTestId
        };

        displayById( self.questionListEmptyId, false );
        displayById( self.questionListHeaderId, false );
            
        var success = function( results ) {
            var found = results.length > 0;
            self.questions = results;
            createAndReplaceElementsById( self.questionListId, "tr", results, self.createExamQuestionElement );
            displayById( self.questionListEmptyId, !found );
            displayById( self.questionListHeaderId, found );
        };

        post( "../examQuestions.php", data, success, onPostError );
    
    };
    
    // UI event handlers
    self.takeExam = function() {
        self.currentExamTestId = this.id;
        self.getExamQuestions();
        doTabClick( 1 );
    };

    self.saveTest = function() {
    
        var form = getElementById( "test" );

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
                };
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

    self.showExamGrades = function() {
        self.currentExamId = this.id;
        self.getStudentExamGrade();
        doTabClick( 2 );
    };

    self.selectExamGrade = function() {
        self.getExamQuestionScores();
        doTabClick( 3 );
    };

    self.selectAnswer = function() {
        self.currentAnswerId = this.id;
        self.getQuestionFeedback();
        doTabClick( 4 );
    };
    
    // student DOM elements
    self.getExam = function( examId ) {
        return self.exams.find( function( exam ) {
            return exam.examId === examId;
        });
    };
    
    self.createExamElement = function( exam ) {

        var tr = document.createElement( "tr" );

        createLabel( exam.examId, exam.examName, tr );

        createAnchor( "#", exam.examId, "Take Exam", self.takeExam, tr );

        createAnchor( "#", exam.examId, "See Grades", self.showExamGrades, tr );
        
        return tr;

    };
    
    self.createExamQuestionElement = function( question ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, question.question, tr );

        createLabel( null, self.getQuestionTraits( question, false ), tr );

        createTextArea( question.questionId, 80, 10, tr );
    
        return tr;
    
    };
    
    self.createExamGradeElement = function( grade ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, grade.examName, tr );
        
        var result = grade.score + " / " + grade.possible;
        
        createAnchor( "#", grade.examId, result, self.selectExamGrade, tr );

        var percent = ( grade.score * 100.0 ) / ( grade.possible * 1.0 );
        
        createLabel( null, percent.toFixed( 1 ) + "%", tr );

        return tr;
    
    };

    self.createFeedbackElement = function( feedback ) {
    
        var tr = document.createElement( "tr" );

        createLabel( null, feedback.description, tr );
        
        var correct = feedback.correct == "1";

        var correctLabel = createLabel( null, correct ? "yes" : "no", tr );

        correctLabel.className += correct ?  " feedback-correct" : " feedback-incorrect";
        
        createLabel( null, feedback.score, tr );

        return tr;

    };

    self.createAnswerElement = function( answer ) {

        var tr = document.createElement( "tr" );

        createLabel( null, answer.question, tr );

        createLabel( null, answer.answer, tr );
        
        var result = answer.score + " / " + answer.possible;
        
        createAnchor( "#", answer.questionId, result, self.selectAnswer, tr );
        
        return tr;

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
        
        if ( sig === "" ) {
            sig = "none";
        }

        return sig;

    };
    
}


