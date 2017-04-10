<?php

include_once "query.php";

$content = trim(file_get_contents("php://input"));
//$content = json_encode( (object) array(
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

$question = json_decode($content);

$id = insert( 'cs490_Question', $question );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , "questionId" );

?>