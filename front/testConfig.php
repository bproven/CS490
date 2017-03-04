<?php

/* 
 *     File:    testConfig
 *     Author:  Bob
 *     Created: Mar 1, 2017
 */

$config = include( "config.php" );

header( "Content-type: application/json" );
echo json_encode( $config );

?>

