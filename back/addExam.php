<?php

include 'query.php';

$content = trim(file_get_contents("php://input"));
//$content = '{ "examName": "test insert exam", "ownerId": "taj1" }';
$exam = json_decode($content);

$id = insert( 'cs490_Exam', $exam );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , "examId" );

?>