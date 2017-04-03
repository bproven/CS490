<?php

include_once "logError.php";

$config = include( "config.php" );

$servername = $config->servername;
$username   = $config->username;
$password   = $config->password;
$dbname     = $config->dbname;

// Create connection
$conn = new mysqli( $servername, $username, $password, $dbname );

// Check connection
if ( mysqli_connect_error() ) {
    logError( "Connection failed: " . mysqli_connect_error() );
} 

return $conn;

?>