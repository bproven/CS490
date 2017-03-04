<?php

include "query.php";

//create table cs490_ExamGrade (
//  ucid   varchar(8) not null,
//  examId int not null,
//  grade  int not null
//);
//
//insert into cs490_ExamGrade
//    values  ('dhg6',1,64),
//            ('rap9',1,55),
//            ('keg9',1,99);

$content = trim(file_get_contents("php://input"));
//$content = '{ "ucid": 1, "examId": 1, "grade": 100 }';
$examGrade = json_decode($content);

$id = insert( 'cs490_StudentExamGrade', $examGrade, false );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , null, false );

?>