<?php

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "examId": 1 }';

header( "Content-type: application/json" );
echo callback( "studentExamFeedback.php", $data );

?>