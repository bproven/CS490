<?php

include "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ownerId": "taj1" }';

$query = json_decode( $data );

$ownerId = $query->ownerId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select examId, examName 
           from cs490_Exam
          where ownerId = '$ownerId'
       order by examName" );

?>