<?php

include_once "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ownerId": "taj1" }';

$query = json_decode( $data );

$ownerId = $query->ownerId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select e.examId, e.examName, s.ucid
           from cs490_Exam e
      left join cs490_StudentExamScore s
             on e.examId = s.examId
          where ownerId = '$ownerId'
       order by examName" );

?>