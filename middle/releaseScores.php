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
//$content = '{ "examId": 1 }';

$rows = callback( "examStudents.php", $content );

$students = json_decode($rows);

$result = (object) array (
    "success" => true
);
        
foreach ( $students as $student ) {
    $data = json_encode( $student );
    $result = json_decode(scoreExam( $data ));
    if ( $result->success == false ) {
        break;
    }
}

header( "Content-type: application/json" );
echo json_encode( $result );

?>
