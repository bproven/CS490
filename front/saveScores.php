<?php

/* 
 *     File:    saveScores.php
 *     Author:  Bob
 *     Created: May 4, 2017
 */

include_once "callmiddle.php";

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
echo callmiddle( "saveScores.php", $data );

?>