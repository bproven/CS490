<?php

/* 
 *     File:    addExamQuestion.php
 *     Author:  Bob
 *     Created: Mar 4, 2017
 */

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "questionId"   => 1,
//    "examId"       => 25 
//) );

header( "Content-type: application/json" );
echo callmiddle( "addExamQuestion.php", $data );

?>