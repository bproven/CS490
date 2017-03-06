<?php

/*Keith temp middle beta CS490
  Students id and ezam Id ill be received as an encoded JSON object
  
    $studentCode = trim(file_get_contents("php://input"));
	$answer = json_decode($studentCode);
*/

include( "callback.php" );
include( "scoring.php");

set_time_limit( 60 );

$data = trim(file_get_contents("php://input"));
//$data = '{ "ucid": "rap9", "examId": 1 }';

$result = scoreExam( $data );

header( "Content-type: application/json" );
echo $result;

?>