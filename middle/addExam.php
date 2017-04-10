<?php

/* 
 *     File:        addExam.php
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 */

include_once "callback.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "examName": "test insert exam", "ownerId": "taj1" }';

header( "Content-type: application/json" );
echo callback( "addExam.php", $data );

?>