<?php

/* 
 *     File:        addExamQuestionAnswers.php
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 */

include "callback.php";

$data = trim(file_get_contents("php://input"));

//$data = '{ 
//                "ucid": "rap9", 
//                "examId": 1, 
//                "answers": [ 
//                    { 
//                        "questionId": 23, 
//                        "answer": "this is another answer" 
//                    }, 
//                    { 
//                        "questionId": 24, 
//                        "answer": "this is another answer" 
//                    } 
//                ] 
//            }';

header( "Content-type: application/json" );
echo callback( "addExamQuestionAnswers.php", $data );

?>