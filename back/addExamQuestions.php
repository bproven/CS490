<?php

include_once "query.php";

//create table cs490_ExamQuestion (
//  examId     int not null,
//  questionId int not null
//);

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": 1, "questionIds": [4,5] }';
$data = json_decode($content);

$result = FALSE;

foreach ( $data->questionIds as $questionId ) {
    
    $question = (object)array(
        "examId"        => $data->examId,
        "questionId"    => $questionId
    );
    
    $result = insert( 'cs490_ExamQuestion', $question, false );
    
    if ( $result === FALSE ) {
        break;
    }
    
}

header( "Content-type: application/json" );
echo jsonInsertResult( $result , null, false );

?>