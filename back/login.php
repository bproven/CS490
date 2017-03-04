<?php

include "query.php";

$content = trim(file_get_contents("php://input"));
//$content = '{ "ucid": "rap9", "pass": "password" }';
$creds = json_decode($content);

$ucid = $creds->ucid;
$pass = $creds->pass;

echo execQueryToJSON( 
      "select id, ucid, firstName, lastName, privelege " .
        "from cs490_User " . 
       "where ucid = '" . $ucid . "'" .
         "and password = MD5( '" . $pass . "' )" );

?>


