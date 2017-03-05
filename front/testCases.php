<?php

include "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "questionId": 23 }';

header( "Content-type: application/json" );
echo callmiddle( "testCases.php", $data );

?>