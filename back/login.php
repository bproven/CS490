<?php

include 'query.php';

$content = trim(file_get_contents("php://input"));
$creds = json_decode($content);

$ucid = $creds->ucid;
$pass = $creds->pass;

echo execQueryJSON( 
      "select ucid, first, last, privelege " .
        "from cs490_users " . 
       "where ucid = '" . $ucid . "'" .
         "and pass = '" . $pass . "'" );

?>


