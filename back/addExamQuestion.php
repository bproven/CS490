<?php

include "query.php";

//create table cs490_ExamQuestion (
//  examId     int not null,
//  questionId int not null,
//  points     int not null
//);

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1, "questionId": 26, "points": 12 }';
$question = json_decode($content);

$id = insert( 'cs490_ExamQuestion', $question, false );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , null, false );

?>