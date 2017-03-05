<?php

include "callmiddle.php";

header( "Content-type: application/json" );
echo callmiddle( "questions.php" );

?>