<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "dhg6", "examId": 1 }';

$query = json_decode( $data );

$ucid   = $query->ucid;
$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select s.*, q.question, q.difficulty, a.answer
           from cs490_StudentExamQuestionScore s
           join cs490_Question q on q.questionId = s.questionId
           join cs490_ExamQuestionAnswer a 
             on a.ucid = s.ucid
            and a.examId = s.examId
            and a.questionId = s.questionId
          where s.ucid = '$ucid'
            and s.examId = $examId" );

?>