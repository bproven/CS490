<?php

/* 
 *     File:    examStudents.php
 *     Author:  Bob
 *     Created: Mar 6, 2017
 */

include "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1 }';

$query = json_decode( $content );

$examId = $query->examId;

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select distinct ucid, examId
           from cs490_examquestionanswer
          where examId = $examId" ); 

?>




