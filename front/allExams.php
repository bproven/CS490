<?php

include_once "callmiddle.php";

header( "Content-type: application/json" );
echo callmiddle( "allExams.php" );

?>