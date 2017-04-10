<?php

/* 
 *     File:    addQuestion
 *     Author:  Bob
 *     Created: Mar 4, 2017
 */

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = json_encode( (object) array(
//    "question"   => "q",
//    "argument1"  => "int", 
//    "returnType" => "int", 
//    "difficulty" => 0, 
//    "functionName" => "power", 
//    "hasIf"     => false, 
//    "hasWhile"  => false, 
//    "hasFor"    => false, 
//    "hasRecursion" => false 
//) );

header( "Content-type: application/json" );
echo callmiddle( "addQuestion.php", $data );

?>