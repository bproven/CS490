<?php

/* 
 *     File:    saveExamScore.php
 *     Author:  Keith
 *     Created: May 5, 2017
 */

include_once "callback.php";

$data = file_get_contents( "score4.json" );

header( "Content-type: application/json" );
echo callback( "saveExamScore.php", $data );

?>
