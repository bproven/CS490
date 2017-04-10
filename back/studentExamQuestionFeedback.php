<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1, "questionId": 23 }';

$query = json_decode( $data );

$ucid   = $query->ucid;
$examId = $query->examId;
$questionId = $query->questionId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select * 
           from cs490_StudentExamQuestionFeedback
          where ucid = '$ucid'
            and examId = $examId
            and questionId = $questionId" );

?>