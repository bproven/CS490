<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "examId": "1" }';

$query = json_decode( $data );

$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select q.*, a.*
           from cs490_ExamQuestionAnswer a
           join cs490_Question q on a.questionId = q.questionId
          where a.examId = $examId
          order 
             by a.ucid" );

?>