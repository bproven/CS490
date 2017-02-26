<?php

include 'callback.php';

header( "Content-type: application/json" );
echo callback( "users.php" );

?>