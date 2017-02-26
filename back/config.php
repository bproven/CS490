<?php

    $debug = FALSE;
    
    if ( file_exists( "debug.php" ) ) {
        $debug = include( "debug.php" );
    }
   
    $config = NULL;
   
    if ( $debug ) {
        $config = (object) array(
            "servername"    => "localhost",
            "username"      => "root",
            "password"      => "enAleyEd",
            "dbname"        => "dhg6"    
        );
    }
    else {
        $config = (object) array(
            "servername"    => "sql2.njit.edu",
            "username"      => "dhg6",
            "password"      => "VkwQg0fD",
            "dbname"        => "dhg6"    
        );
    }
    
    return $config;

?>