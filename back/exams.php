<?php

include "query.php";

header( "Content-type: application/json" );
echo execQueryToJSON( "select * from cs490_ExamQuestions eq 
	join cs490_Questions q on q.Id = eq.QuestionId
	order by ExamId" );

?>