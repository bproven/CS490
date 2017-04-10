<?php

/* 
 *     File:    addTestCase.php
 *     Author:  Bob
 *     Created: Mar 4, 2017
 */

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "questionId": 24, "argument1": "1", "argument2": "1", "argument3": null, "argument4": null, "returnValue": "1" }';

header( "Content-type: application/json" );
echo callmiddle( "addTestCase.php", $data );

?>