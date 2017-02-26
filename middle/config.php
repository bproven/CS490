<?php

    $debug = FALSE;
    
    if ( file_exists( "debug.php" ) ) {
        $debug = include( "debug.php" );
    }
   
    $config = NULL;
   
    if ( $debug ) {
        $config = (object) array(
            "back" => "http://localhost/~rap9/cs490/back/"
        );
    }
    else {
        $config = (object) array(
            "back" => "http://afsaccess2/~dhg9/cs490/back/"
        );
    }
    
    return $config;

?>