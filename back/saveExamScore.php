<?php

include_once "query.php";
include_once "logError.php";

set_time_limit( 600 );

$content = trim(file_get_contents("php://input"));

//$content = '{ 
//                "ucid": "rap9", 
//                "examId": 1, 
//                "score": 99,
//                "possible": 4,
//                "questions": [ 
//                    { 
//                        "questionId": 23, 
//                        "score": 1,
//                        "possible": 2, 
//                        "feedback": [
//                             {
//                                  "description": "function name incorrect",
//                                  "correct": false,
//                                  "score" : 0,
//                                  "possible" : 1
//                             },
//                             {
//                                  "description": "function compiles",
//                                  "correct": true,
//                                  "score" : 1,
//                                  "possible" : 1
//                             }
//                        ]
//                    }, 
//                    { 
//                        "questionId": 24, 
//                        "score": 1,
//                        "possible": 2,
//                        "feedback": [
//                             {
//                                  "description": "function name incorrect",
//                                  "correct": false,
//                                  "score": 0,
//                                  "possible": 1
//                             },
//                             {
//                                  "description": "function compiles",
//                                  "correct": true,
//                                  "score": 1,
//                                  "possible": 1
//                             }
//                        ]
//                    } 
//                ] 
//            }';

//$content = file_get_contents( "score.json" );

function makeQuestion( $ucid, $examId, $object ) 
{
    return (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "questionId"    => $object->questionId,
        "score"         => $object->score,
        "possible"      => $object->possible
    );
}

function makeFeedback( $ucid, $examId, $questionId, $object ) 
{
    return (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "questionId"    => $questionId,
        "description"   => $object->description,
        "correct"       => $object->correct,
        "score"         => $object->score,
        "possible"      => $object->possible
    );
}

logError( $content );

$data = json_decode($content);

$ucid   = $data->ucid;
$examId = $data->examId;

// first delete the feedback

$result = execQuery( 
        "delete from cs490_StudentExamQuestionFeedback
          where ucid = '$ucid'
            and examId = $examId" );

// then the question scores

if ( $result ) {
    
    $result = execQuery( 
            "delete from cs490_StudentExamQuestionScore
              where ucid = '$ucid'
                and examId = $examId" );
    
}

// then delete the exam grades

if ( $result ) {
    
    $result = execQuery( 
            "delete from cs490_StudentExamScore
              where ucid = '$ucid'
                and examId = $examId" );
    
}

if ( $result ) {
    
    $questions = $data->questions;
    
    // save the exam grade
    $examGrade = (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "score"         => $data->score,
        "possible"      => $data->possible
    );
    
    $result = insert( 'cs490_StudentExamScore', $examGrade, false );
    
    if ( $result ) {
        
        foreach ( $questions as $question ) {

            // save each question score

            $q = makeQuestion($ucid, $examId, $question );

            $result = insert( 'cs490_StudentExamQuestionScore', $q, false );

            if ( !$result ) {
                break;
            }
            
            $feedbacks = $question->feedback;

            foreach ( $feedbacks as $feedback ) {

                // save the feedback

                $fb = makeFeedback($ucid, $examId, $question->questionId, $feedback);

                $result = insert( 'cs490_StudentExamQuestionFeedback', $fb, false );

                if ( !$result ) {
                    break;
                }

            }

        }
    
    }
    
}

header( "Content-type: application/json" );
$result = jsonInsertResult( $result, null, false );

logError( $result );

echo $result;

?>