<?php

/* 
 *     File:    releaseScores.php
 *     Author:  Keith
 *     Created: Mar 5, 2017
 */

include_once "callback.php";
include_once "scoring.php";

set_time_limit( 600 );

$content = trim(file_get_contents("php://input"));
//$content = '{ "examId": "4" }';

$rows = callback( "examStudents.php", $content );

$students = json_decode($rows);

$result = (object) array (
    "success" => true,
    "ucids" => []
);
        
foreach ( $students as $student ) {
    $result->ucids[] = $student->ucid;
    $data = json_encode( $student );
    $score_result = json_decode( scoreExam( $data ) );
    $result->success = $score_result->success;
    if ( $result->success == false ) {
        break;
    }
}

header( "Content-type: application/json" );
echo json_encode( $result );

?>
