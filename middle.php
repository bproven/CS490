<?php

	//To communicate with Database
	$content = trim(file_get_contents("php://input"));

	$decoded = json_decode($content);

	$id   = $decoded->user;
	$pass = $decoded->pass;

	$URL = "http://afsaccess1.njit.edu/~rap9/cs490/back.php";
	
	$data = array( "UCID" => $id, "password" => $pass);
                                       
	$data_string = json_encode($data); 
                                                                                  
	$ch = curl_init($URL);                                                                      
	curl_setopt($ch, CURLOPT_POST, 1);                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);   

	$result = curl_exec($ch);

    if ( $result === false ) {
        
        $error_msg = "error: " . curl_error( $ch );

        error_log( $error_msg );
        
        http_response_code( 500 );
        
    }

	curl_close($ch);

    $decoded = json_decode( $result );
    $our_result = $decoded->result;

	//NJIT Server Communication
	
	$username=$id;
	$password=$pass; 
	$uid='0xACA021';
	$postdata = 'user='.$username.'&pass='.$password.'&uuid='.$uid;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://cp4.njit.edu/cp/home/login');
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	
	//Make NJIT Think HTTP Is Coming From Browser
	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

	//Make cURL Return String
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec ($ch);
	curl_close ($ch); 

    $njit_result = $result === '';

	$data = array("njitResult" => $njit_result, "ourResult" => $our_result);
	$data_string = json_encode($data);

    header("Content-Type:application/json");

	echo $data_string;

?>