<?php

include 'query.php';

$content = trim(file_get_contents("php://input"));
$creds = json_decode($content);

$ucid = $creds->ucid;
$pass = $creds->pass;

echo execQueryToJSON( 
      "select ucid, firstName, lastName, privelege " .
        "from cs490_Users " . 
       "where ucid = '" . $ucid . "'" .
         "and password = '" . $pass . "'" );

?>

