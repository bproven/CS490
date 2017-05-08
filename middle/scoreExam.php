<?php

/*Keith temp middle beta CS490
  Students id and ezam Id ill be received as an encoded JSON object
  
    $studentCode = trim(file_get_contents("php://input"));
	$answer = json_decode($studentCode);
*/

include_once "callback.php";
include_once "scoring.php";

set_time_limit( 600 );

$data = trim(file_get_contents("php://input"));
//$data = '{ "examId": "4", "ucid": "rap9" }';

$result = scoreExam( $data );

header( "Content-type: application/json" );
echo $result;

?>