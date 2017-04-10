<?php

include_once "callback.php";

$data = trim(file_get_contents("php://input"));

header( "Content-type: application/json" );
echo callback( "exams.php", $data );

?>