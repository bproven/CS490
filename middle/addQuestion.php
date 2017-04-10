<?php

/* 
 *     File:        addQuestion
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 */

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "question" => "q",
//    "argument1"  => "int", 
//    "returnType" => "int", 
//    "difficulty" => "low", 
//    "functionName" => "power", 
//    "hasIf"     => false, 
//    "hasWhile"  => false, 
//    "hasFor"    => false, 
//    "hasRecursion" => false 
//) );

header( "Content-type: application/json" );
echo callback( "addQuestion.php", $data );

?>