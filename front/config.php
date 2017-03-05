<?php

    $config = null;

    if ( file_exists( "userConfig.php" ) ) {
        
        $config = include( "userConfig.php" );
        
    }
    else {
        
        $config = (object) array(
            "middle" => "http://afsaccess2.njit.edu/~keg9/cs490/middle/"
        );
        
    }
    
    return $config;

?>