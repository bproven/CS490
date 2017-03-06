<?php

/* 
 *     File:    releaseScores
 *     Author:  Bob Provencher
 *     Created: Mar 6, 2017
 */

include "callmiddle.php";

//$data = trim(file_get_contents("php://input"));
$data = '{ "examId": 1 }';

header( "Content-type: application/json" );
echo callmiddle( "releaseScores.php", $data );

?>

