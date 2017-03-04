<?php

    $debug = FALSE;
    
    if ( file_exists( "debug.php" ) ) {
        $debug = include( "debug.php" );
    }
   
    $config = NULL;
   
    if ( $debug ) {
        $config = (object) array(
            "middle"        => "http://localhost/~rap9/cs490/middle/"
        );
    }
    else {
        $config = (object) array(
            "middle"        => "http://afsaccess2.njit.edu/~keg9/cs490/middle/"
        );
    }
    
    return $config;

?>