<?php

include "callmiddle.php";

header( "Content-type: application/json" );
echo callmiddle( "users.php" );

?>