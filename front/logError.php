<?php

/* 
 *     File:    logError.php
 *     Author:  Bob Provencher
 *     Created: Mar 27, 2017
 */

function logError( $error ) {
    file_put_contents("error.log", $error . "\n", FILE_APPEND);
}

//logError( "this is a test" );

?>
