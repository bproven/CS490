<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
// TODO: select student
//$data = '{ "examId": 1 }';

$query = json_decode( $data );

$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select f.*, q.question, a.answer 
           from cs490_StudentExamQuestionFeedback f
           join cs490_Question q
             on f.questionId = q.questionId
           join cs490_ExamQuestionAnswer a 
             on f.ucid = a.ucid 
            and f.examId = a.examId
            and f.questionId = a.questionId
          where f.examId = $examId
          order 
             by f.questionId, f.feedbackId" );

?>