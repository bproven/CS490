<?php

/* 
 *     File:        saveScores.php
 *     Author:      Keith
 *     Created:     May 4, 2017
 *     Description: 
 */

include_once "callback.php";

$data = trim(file_get_contents("php://input"));

//$data = '{ 
//                "ucid": "rap9", 
//                "examId": "1", 
//                "scores": [ 
//                    { 
//                        "questionId": "1", 
//                        "score": "14"
//                    }, 
//                    { 
//                        "questionId": "2", 
//                        "score": "1"
//                    } 
//                ] 
//            }';

header( "Content-type: application/json" );
echo callback( "saveScores.php", $data );

?>