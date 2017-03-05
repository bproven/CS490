<?php

    $config = null;

    if ( file_exists( "userConfig.php" ) ) {
        
        $config = include( "userConfig.php" );
        
    }
    else {
        
        $config = (object) array(
            "servername"    => "sql2.njit.edu",
            "username"      => "dhg6",
            "password"      => "VkwQg0fD",
            "dbname"        => "dhg6",
            "back"          => "http://afsaccess2.njit.edu/~dhg9/cs490/back/"
        );
        
    }
    
    return $config;

?>