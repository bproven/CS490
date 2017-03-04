<?php

include "query.php";

$data = trim(file_get_contents("php://input"));

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select examId, examName 
           from cs490_Exams
          where ownerId == $data.ownerId
       order by examName" );

?>