<?php

include "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1 }';

$query = json_decode( $data );

$ucid   = $query->ucid;
$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select q.*, a.*
           from cs490_ExamQuestionAnswer a
           join cs490_Question q on a.questionId = q.questionId
          where a.examId = $examId
            and a.ucid = '$ucid'" );

?>