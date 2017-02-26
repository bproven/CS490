<?php

include "query.php";

header( "Content-type: application/json" );
echo execQueryToJSON( "SELECT * FROM cs490_Questions" );

?>