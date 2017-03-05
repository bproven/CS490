<?php

/* 
 *     File:        addExamQuestion.php
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 */

include "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "examId" => 1,
//    "questionId" => 26
//) );

header( "Content-type: application/json" );
echo callback( "addExamQuestion.php", $data );

?>