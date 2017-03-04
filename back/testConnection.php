<?php

include "query.php";

$results = execQuery( "select version() as version" );
        
echo $results[ 0 ]->version;

?>
