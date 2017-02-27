<?php

include 'query.php';

//create table cs490_TestCase (
//    testCaseId    int not null auto_increment primary key,
//    questionId    int not null,
//    argument1     varchar(16),
//    argument2     varchar(16),
//    argument3     varchar(16),
//    argument4     varchar(16),
//    returnValue   varchar(16)
//);

$content = trim(file_get_contents("php://input"));
//$content = '{ "questionId": 24, "argument1": "int", "argument2": "int", "argument3": null, "argument4": null, "returnValue": "int" }';
$testCase = json_decode($content);

$id = insert( 'cs490_TestCase', $testCase );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , "testCaseId" );

?>