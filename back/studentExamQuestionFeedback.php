<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": "1", "questionId": "1" }';

$query = json_decode( $data );

$ucid   = $query->ucid;
$examId = $query->examId;
$questionId = $query->questionId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select f.*, q.questionId, q.question, a.answer 
           from cs490_StudentExamQuestionFeedback f
           join cs490_Question q
             on f.questionId = q.questionId
           join cs490_ExamQuestionAnswer a 
             on f.ucid = a.ucid 
            and f.examId = a.examId
            and f.questionId = a.questionId           
          where f.ucid = '$ucid'
            and f.examId = $examId
            and f.questionId = $questionId" );

?>