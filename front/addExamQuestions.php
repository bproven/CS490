<?php

/* 
 *     File:    addExamQuestions.php
 *     Author:  Bob
 *     Created: April 30, 2017
 */

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "examId"      => 1,
//    "questionIds" => [ 4, 5 ]
//) );

header( "Content-type: application/json" );
echo callmiddle( "addExamQuestions.php", $data );

?>