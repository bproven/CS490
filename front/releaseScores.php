<?php

/* 
 *     File:    releaseScores
 *     Author:  Bob Provencher
 *     Created: Mar 6, 2017
 */

include_once "callmiddle.php";

set_time_limit( 600 );

//$data = trim(file_get_contents("php://input"));
$data = '{ "examId": "1" }';

header( "Content-type: application/json" );
echo callmiddle( "releaseScores.php", $data );

?>

