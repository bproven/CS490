<?php

    $config = null;
    
    if ( file_exists( "userConfig.php" ) ) {
        
        $config = include( "userConfig.php" );
        
    }
    else {
        
        $config = (object) array(
            "back" => "http://afsaccess2.njit.edu/~dhg9/cs490/back/"
        );
        
    }
    
    return $config;

?>