<?php

/* 
 *     File:    logError.php
 *     Author:  Bob Provencher
 *     Created: Mar 27, 2017
 */

function logError( $error ) {
    file_put_contents( "error.log", date( "Y-m-d H:i:s: " ) . $error . "\n", FILE_APPEND);
}

logError( "log initialized." );

?>
