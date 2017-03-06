<?php

include "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1 }';

$data = json_decode($content);

header( "Content-type: application/json" );
echo execQueryToJSON( 
      "select eq.*, q.* 
         from cs490_ExamQuestion eq 
         join cs490_Question q on q.questionId = eq.QuestionId
        where examId = $data->examId" );

?>