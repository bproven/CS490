<?php

function execQuery( $sql )
{

    // Create connection
    $conn = include( "connect.php" );

    $results = [];

    $records = $conn->query( $sql );
    
    if ( $records ) {

        while ( $row = $records->fetch_object() ) {
            $results[] = $row;
        }

    }

    $conn->close();
    
    return $results;
    
}

function execQueryToJSON( $sql ) {
    
    $results = execQuery( $sql );
    return json_encode( $results );
    
}

?>
