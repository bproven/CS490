<?php

include_once "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "ucid": 1, "examId": 1, "score": 100, "possible": 100 }';
$examGrade = json_decode($content);

$id = insert( 'cs490_StudentExamScore', $examGrade, false );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , null, false );

?>