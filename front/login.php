<?php

include "callmiddle.php";

$data = trim(file_get_contents("php://input"));

header( "Content-type: application/json" );
echo callmiddle( "login.php", $data );

?>