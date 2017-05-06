<?php

/* 
 *     File:    saveExamScore.php
 *     Author:  Keith
 *     Created: May 5, 2017
 */

$data = file_get_contents( "score.json" );

header( "Content-type: application/json" );
echo callback( "saveExamScore.php", $data );

?>
