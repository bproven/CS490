<?php

/* 
 *     File:        addTestCase.php
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 */

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "questionId": 24, "argument1": "1", "argument2": "1", "argument3": null, "argument4": null, "returnValue": "1" }';

header( "Content-type: application/json" );
echo callback( "addTestCase.php", $data );

?>