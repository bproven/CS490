<?php

include "query.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1 }';

$query = json_decode( $data );

$ucid   = $query->ucid;
$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select seg.*, e.examName
           from cs490_StudentExamScore seg
           join cs490_Exam e on seg.examId = e.examId
          where seg.ucid = '$ucid'
            and seg.examId = $examId" );

?>