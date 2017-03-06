<?php

include "query.php";

$content = trim(file_get_contents("php://input"));

//$content = '{ 
//                "ucid": "rap9", 
//                "examId": 1, 
//                "grade": 99,
//                "questions": [ 
//                    { 
//                        "questionId": 23, 
//                        "score": 2,
//                        "feedback": [
//                             {
//                                  "description": "function name incorrect",
//                                  "correct": false,
//                                  "score" : 0
//                             },
//                             {
//                                  "description": "function compiles",
//                                  "correct": true,
//                                  "score" : 1
//                             }
//                        ]
//                    }, 
//                    { 
//                        "questionId": 24, 
//                        "score": 2,
//                        "feedback": [
//                             {
//                                  "description": "function name incorrect",
//                                  "correct": false,
//                                  "score" : 0
//                             },
//                             {
//                                  "description": "function compiles",
//                                  "correct": true,
//                                  "score" : 1
//                             }
//                        ]
//                    } 
//                ] 
//            }';

function makeQuestion( $ucid, $examId, $object ) 
{
    return (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "questionId"    => $object->questionId,
        "score"         => $object->score
    );
}

function makeFeedback( $ucid, $examId, $object ) 
{
    return (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "description"   => $object->description,
        "correct"       => $object->correct,
        "score"         => $object->score
    );
}

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
            "delete from cs490_StudentExamGrade
              where ucid = '$ucid'
                and examId = $examId" );
    
}

if ( $result ) {
    
    $questions = $data->questions;
    
    // save the exam grade
    $examGrade = (object) array(
        "ucid"          => $ucid,
        "examId"        => $examId,
        "grade"         => $data->grade
    );
    
    $result = insert( 'cs490_StudentExamGrade', $examGrade, false );
    
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

                $fb = makeFeedback($ucid, $examId, $feedback);

                $result = insert( 'cs490_StudentExamQuestionFeedback', $fb, false );

                if ( !$result ) {
                    break;
                }

            }

        }
    
    }
    
}

header( "Content-type: application/json" );
echo jsonInsertResult( $result, null, false );

?>