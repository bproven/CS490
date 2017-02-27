<?php

function callback( $page, $object ) {
    
    $config = include( "config.php" );

    $ch = curl_init( $config->back . $page );
    
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );    
    
    if ( $object != null ) {
        $data = json_encode( $object );
        curl_setopt( $ch, CURLOPT_POST, 1 );                                                                     
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );                                                                  
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data) )                                                                       
        );     
    }
    
    $result = curl_exec( $ch );
    
    curl_close( $ch );
    
    return $result;
    
}

?>
