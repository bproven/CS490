<?php

include 'query.php';

//create table cs490_ExamQuestionAnswer (
//    ucid        varchar(8) not null,
//    examId      int not null,
//    questionId  int not null,
//    answer      text
//);
//
//insert into cs490_ExamQuestionAnswer
//    values  ( 'dhg6', 1, 26, 'this is a sample answer' );

$content = trim(file_get_contents("php://input"));
//$content = '{ "ucid": "dhg6", "examId": 1, "questionId": 27, "answer": "this is another answer" }';
$question = json_decode($content);

$id = insert( 'cs490_ExamQuestionAnswer', $question, false );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , null, false );

?>