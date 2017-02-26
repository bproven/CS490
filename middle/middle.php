<?php
	//To communicate with Database
	$content = trim(file_get_contents("php://input"));
	$decoded = json_decode($content);

	$id=($decoded->user);
	$pass=($decoded->pass);
        
        $config = include( "config.php" );

	$URL = $config->back . "view.php";
	
	$data = array(UCID => ("$id"), 'password' => ("$pass"));
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
	echo $result;
	curl_close($ch);
	
?>