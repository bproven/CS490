<?php

/* 
 *      File:           allExams.php
 *      Author:         Dan Gordon
 *      Created:        Mar 1, 2017
 *      Description:    Returns all exams
 */

include "query.php";

header( "Content-type: application/json" );

echo execQueryToJSON( 
        "select examId, examName 
           from cs490_Exam
       order by examName" );

?>