<?php

include "query.php";

//create table cs490_ExamQuestion (
//  examId     int not null,
//  questionId int not null
//);

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1, "questionId": 26 }';
$question = json_decode($content);

$result = insert( 'cs490_ExamQuestion', $question, false );

header( "Content-type: application/json" );
echo jsonInsertResult( $result , null, false );

?>