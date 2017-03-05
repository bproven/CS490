<?php

include "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "questionId": 23 }';
$data = json_decode($content);

header( "Content-type: application/json" );
echo execQueryToJSON( 
      "select * " .
        "from cs490_TestCase " . 
       "where questionId = " . $data->questionId );

?>