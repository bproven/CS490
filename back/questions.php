<?php

include_once "query.php";

header( "Content-type: application/json" );
echo execQueryToJSON( "select * from cs490_Question" );

?>