<?php

include "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1 }';

header( "Content-type: application/json" );
echo callmiddle( "studentExamGrade.php", $data );

?>