<?php

include_once "callback.php";

header( "Content-type: application/json" );
echo callback( "allExams.php" );

?>