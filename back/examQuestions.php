<?php

include "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1 }';
$data = json_decode($content);

header( "Content-type: application/json" );
echo execQueryToJSON( 
      "select * " .
        "from cs490_ExamQuestion " . 
       "where examId = " . $data->examId );

?>