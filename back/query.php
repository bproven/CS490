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

function keys( $object ) {
    
    $keys = '';
    
    foreach ( $object as $key => $value ) {
        if ( $keys != '' ) {
            $keys = $keys . ', ';
        }
        $keys = $keys . $key;
    }
    
    return $keys;
}

function values( $object, $conn ) {
    
    $values = '';
    
    foreach ( $object as $key => $value ) {
        if ( $values != '' ) {
            $values = $values . ', ';
        }
        $type = gettype( $value );
        $quote = '';
        if ( $type == "string" ) {
            $quote = '"';
            $value = $conn->real_escape_string( $value );
            if ( $value == null ) {
                $value = "null"; 
                $quote = '';
            }
        }
        else if ( $type == "boolean" ) {
            $value = $value ? "true" : "false";
        }
        $values = $values . $quote . $value . $quote;
    }
    
    return $values;
    
}

function insert( $table, $object, $getId = true ) {
    
    // Create connection
    $conn = include( "connect.php" );
    
    $query = "insert into " . $table . 
                "( " . keys( $object ) . " )" .
                " values " .
                "( " . values( $object, $conn ) . " );";
    
    error_log( $query );
    
    $result = $conn->query( $query );
    
    if ( $getId ) {
        if ( $result ) {
            $result = mysqli_insert_id( $conn );
        }
        else {
            $result = null;
        }
    }
    
    return $result;
    
}

function insertResult( $id, $idName, $getId = true ) {
    
    $success = $getId ? $id != null : $id;
    
    $result = array(
        "success"   => $success
    );
    
    if ( $getId ) {
        $result[ $idName ] = $id == null ? 0 : $id;
    }
    
    $results = (object)$result;
            
    return $results;
}

function jsonInsertResult( $id, $idName, $getId = true ) {
    return json_encode( insertResult( $id, $idName, $getId ) );
}

?>
