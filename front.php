<?php

$response_code = 200;

// make sure we have a valid request
if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
    
    $url = "http://afsaccess1.njit.edu/~keg9/cs490/middle.php";
    $post_data = file_get_contents( "php://input" );
    
    $njit_result = true;
    $our_result = true;
    
    // send request to middle tier
    
    $curl = curl_init();
    
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_POST, true );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $post_data );
    
    session_write_close();
    $result = curl_exec( $curl );
    session_start();
    
    if ( $result === false ) {
        
        $response_code = 500;
        
        header( "Content-Type: text/plain" );
        
        $error_msg = "front.php Curl error: " . curl_error( $curl );
        
        error_log( $error_msg );
        
        echo $error_msg;
        
    }
    else {
        
        // return results

        header( "Content-Type: application/json" );

        echo $result;
    
    }
    
    curl_close( $curl );
    
}
else {

    $response_code = 405;                       // 405: Method Not Allowed

}

http_response_code( $response_code )

?>