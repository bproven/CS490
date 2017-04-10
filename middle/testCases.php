<?php

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "questionId": 23 }';

header( "Content-type: application/json" );
echo callback( "testCases.php", $data );

?>