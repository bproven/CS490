<?php

/* 
 *     File:        addExamQuestions.php
 *     Author:      Keith
 *     Created:     April 30, 2017
 *     Description: 
 */

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "examId" => 1,
//    "questionIds" => [4,5]
//) );

header( "Content-type: application/json" );
echo callback( "addExamQuestions.php", $data );

?>