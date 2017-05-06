<?php

include_once "query.php";
include_once "logError.php";

$content = trim(file_get_contents("php://input"));

//$content = '{ 
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

//$content = file_get_contents( "json.log" );

logError( $content );

$data = json_decode($content);

$ucid   = $data->ucid;
$examId = $data->examId;

$totalScore = 0;

$result = true;

foreach ( $data->scores as $questionScore ) {
    
    $questionId = $questionScore->questionId;
    $score = $questionScore->score;
    
    $result = execQuery( 
        "update cs490_StudentExamQuestionScore
            set score = $score
          where ucid = '$ucid'
            and examId = $examId
            and questionId = $questionId" );

    if ( $result === FALSE ) {
        break;
    }
    
    $totalScore = $totalScore + $score;
    
}

if ( $result !== FALSE ) {
    
    $result = execQuery( 
        "update cs490_StudentExamScore
            set score = $totalScore
          where ucid = '$ucid'
            and examId = $examId" );
    
}

header( "Content-type: application/json" );
$results = jsonResult( $result );

logError( $results );

echo $results;

?>