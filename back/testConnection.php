<?php

include_once "query.php";

$results = execQuery( "select version() as version" );
        
echo $results[ 0 ]->version;

?>
