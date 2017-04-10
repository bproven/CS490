<?php

include_once "query.php";

$content = trim(file_get_contents("php://input"));

//$content = '{ 
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

$data = json_decode($content);

$ucid   = $data->ucid;
$examId = $data->examId;

// first delete the answers

$result = execQuery( 
        "delete from cs490_ExamQuestionAnswer
          where ucid = '$ucid'
            and examId = $examId" );

if ( $result ) {
    
    $answers = $data->answers;

    foreach ( $answers as $answer ) {
        
        $question = (object) array(
            "ucid"          => $ucid,
            "examId"        => $examId,
            "questionId"    => $answer->questionId,
            "answer"        => $answer->answer
        );
        
        $result = insert( 'cs490_ExamQuestionAnswer', $question, false );
            
        if ( !$result ) {
            break;
        }

    }
    
}

header( "Content-type: application/json" );
echo jsonInsertResult( $result , null, false );

?>