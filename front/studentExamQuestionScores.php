<?php

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1 }';

header( "Content-type: application/json" );
echo callmiddle( "studentExamQuestionScores.php", $data );

?>