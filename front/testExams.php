<?php

    $object = (object) array (
        "ownerId" => "taj1"
    );
    
    $data = json_encode( $object );

    $URL = "exams.php";   
    
    $ch = curl_init($URL);           
    
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );    
    
    if ( $data != NULL ) {
        curl_setopt( $ch, CURLOPT_POST, 1 );                                                                     
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );                                                                  
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data) )                                                                       
        );     
    }
    
    $result = curl_exec($ch);
    
    curl_close($ch);
    
    echo $result;


?>
