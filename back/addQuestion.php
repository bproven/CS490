<?php

include 'query.php';

$content = trim(file_get_contents("php://input"));
$question = json_decode($content);

$id = insert( 'cs490_Question', $question );

header( "Content-type: application/json" );
echo jsonInsertResult( $id , "questionId" );

?>