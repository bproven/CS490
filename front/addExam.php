<?php

/* 
 *     File:    addExam.php
 *     Author:  Bob
 *     Created: Mar 4, 2017
 */

include_once "callmiddle.php";

$data = trim(file_get_contents("php://input"));
//$data = '{ "examName": "test insert exam", "ownerId": "taj1" }';

header( "Content-type: application/json" );
echo callmiddle( "addExam.php", $data );

?>