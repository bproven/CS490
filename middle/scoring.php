<?php

/*Keith temp middle beta CS490
  Students id and ezam Id ill be received as an encoded JSON object
  
    $studentCode = trim(file_get_contents("php://input"));
	$answer = json_decode($studentCode);
*/

include_once "logError.php";
include_once "callback.php";

function makeFeedback( $description, $correct, $score, $possible ) 
{
    return (object)array(
        "description"   => $description,
        "correct"       => $correct,
        "score"         => $score,
        "possible"      => $possible
    );
}

function makeQuestion( $answer, $argTypes, $score, $possible )
{
    return (object) array(
        "questionId"    => $answer->questionId,
        "functionName"  => $answer->functionName,
        "hasIf"         => $answer->hasIf,
        "hasWhile"      => $answer->hasWhile,
        "hasFor"        => $answer->hasFor,
        "hasRecursion"  => $answer->hasRecursion,
        "score"         => $score,
        "possible"      => $possible,
        "argTypes"      => $argTypes,
        "feedback"      => [],
        "testCases"     => []
    );
}

function makeExamScore( $ucid, $examId, $score, $possible ) 
{
    return (object) array(
        "ucid"      => $ucid,
        "examId"    => $examId,
        "score"     => $score,
        "possible"  => $possible,
        "questions" => []
    );
}

function addfeedback( $question, $description, $correct, $score, $possible ) {
    
    $feedback = makeFeedback( $description, $correct, $score, $possible );
    
    $question->score = $question->score + $score;
    $question->possible = $question->possible + $possible;
    $question->feedback[] = $feedback;
    
}

//test if student named function correctly
function scoreFuncname( $answer, $question ) {
    
    $score = 0;
    
    $answerText = $answer->answer;
    $functionName = $answer->functionName;
    
    $correct = strpos($answerText, $functionName) == true;
    $description = "Function Name";
    
    if( $correct == true)
    { 
	$score = 1;
    }   
    else{
	$score = 0;
    }
    
    addfeedback( $question, $description, $correct, $score, 1 );

}

function run( $command, &$results ) {
    
    $output = array();
    $return_var = null;
    $result = false;
    $results = "";
    
    // 2>&1 redirect stderr to stdout, capturing output
    exec( $command . " 2>&1", $output, $return_var );
    
    if ( !is_null( $return_var ) ) {
        logError( $command . " returned " . $return_var );
        $result = $return_var == 0;
    }
    
    if ( !is_null( $output ) ) {
        foreach ( $output as $line ) {
            logError( $line );
            if ( strlen( $results ) > 0 ) {
                $results = $results . PHP_EOL;
            }
            $results = $results . $line;
        }
    }
    
    return $result;
    
}

function compile( $file, &$results ) {
    return run( "javac $file", $results ); //compile Java
}

function getTestCases( $questionId ) {
    
    $data = '{ "questionId": ' . $questionId . ' }';

    header( "Content-type: application/json" );
    
    $testCases = json_decode( callback( "testCases.php", $data ) );
    
    return $testCases;
    
}

function findFuncName( $code ) {
    
    $result = null;
    
    $pos = strpos( $code, "(" );
    
    if ( $pos !== false && $pos > 0 ) {
        $sub = substr( $code, 0, $pos );
        $pos = strrchr( $sub, " " );    
        if ( $pos !== false ) {
            $result = substr( $pos, 1 );
        }
    }

    return $result;
    
}

function generateSource( $file, $answer, $question ) {
    
    $answerText = $answer->answer;

    // temp test
    $testCases = getTestCases( $question->questionId );
    
    $question->testCases = $testCases;
    
    file_put_contents( $file, "public class test {" . PHP_EOL . PHP_EOL ); //create Java file and write, append code
    file_put_contents( $file, PHP_EOL . $answerText . PHP_EOL . PHP_EOL, FILE_APPEND );
    file_put_contents( $file, "\tpublic static void main( String[] args ) {" . PHP_EOL, FILE_APPEND );
    
    $funcName = findFuncName( $answerText );
    
    if ( is_null( $funcName ) ) {
        $funcName = $question->functionName;
    }

    file_put_contents( $file, "\t\tSystem.out.print( \"[\" );" . PHP_EOL, FILE_APPEND );
    
    $first = true;
    
    // one line for each test case
    foreach ( $testCases as $testCase ) {
        
        if ( !$first ) {
            file_put_contents( $file, "\t\tSystem.out.println( \",\" );" . PHP_EOL, FILE_APPEND );
        }
        
        $first = false;
        
        file_put_contents( $file, "\t\tSystem.out.print( \"{ \\\"testCaseId\\\": \\\"$testCase->testCaseId\\\", \\\"resultValue\\\": \\\"\" );" . PHP_EOL, FILE_APPEND );
        
        $args = [];
        
        $args[] = $testCase->argument1;
        $args[] = $testCase->argument2;
        $args[] = $testCase->argument3;
        $args[] = $testCase->argument4;
        
        $argvalue = "";
        
        $index = 0;
        
        foreach ( $args as $arg ) {
            if ( !is_null( $arg ) ) {
                $argType = $question->argTypes[ $index ];
                $isString = false;
                if ( !is_null( $argType ) ) {
                    $isString = $argType == "String";
                }
                if ( strlen( $argvalue ) > 0 ) {
                    $argvalue = $argvalue . ", ";
                }
                if ( $isString ) {
                    $argvalue = $argvalue . '"';
                }
                $argvalue = $argvalue . $arg;
                if ( $isString ) {
                    $argvalue = $argvalue . '"';
                }
            }
            $index = $index + 1;
        }
        
        file_put_contents( $file, "\t\tSystem.out.print( $funcName( $argvalue ) );" . PHP_EOL, FILE_APPEND );
        
        file_put_contents( $file, "\t\tSystem.out.print( \"\\\" }\" );" . PHP_EOL, FILE_APPEND );
        
    }
    
    file_put_contents( $file, "\t\tSystem.out.println( \"]\" );" . PHP_EOL, FILE_APPEND );
    
    file_put_contents( $file, "\t}" . PHP_EOL . PHP_EOL . "}", FILE_APPEND );
    
    return $file;
    
}

function generateSourceAndCompile( $file, $answer, $question, &$results ) {
    
    generateSource( $file, $answer, $question );
    
    $compiled = "test.class";
    
    if ( file_exists( $compiled ) == true ){
        unlink( $compiled );
    }
    
    //compile Java
    return compile( $file, $results );
    
}

function scoreCompilation( $answer, $question ) {
    
    $file = "test.java";
    $score = 0;
    $results = array();
    
    $correct = generateSourceAndCompile( $file, $answer, $question, $results );

    $feedback = "Compilation";
    
    if( $correct == true ) { 
        $score = 1;
    }
    else{
        $score = 0;
    }

    addfeedback( $question, $feedback, $correct, $score, 1 );

}

function scoreRun( $question ) {
    
    $cmd = "java test";
    
    $results = array();
    
    $result = run( $cmd, $results );
    
    $score = 0;
    
    if ( $result === true ) {
        $score = 1;
    }
    
    $description = "Run";
    
    addfeedback( $question, $description, $result, $score, 1 );
    
    $testCases = json_decode( $results );
    
    foreach ( $testCases as $testCase ) {
        
        $testCaseId = $testCase->testCaseId;
        
        $expected = null;
        
        foreach ( $question->testCases as $expectedTestCase ) {
            if ( $expectedTestCase->testCaseId == $testCaseId ) {
                $expected = $expectedTestCase;
                break;
            }
        }
        
        $expectedResult = "unknown";
        
        if ( !is_null( $expected ) ) {
            $expectedResult = $expected->returnValue;
        }
        
        $actualResult = $testCase->resultValue;
        
        $correct = $actualResult == $expectedResult;
        
        $score = 0;
        
        if ( $correct == true ) {
            $score = 1;
        }
        
        $description = "testCase $testCaseId expected: $expectedResult, actual: $actualResult";
        
        addfeedback( $question, $description, $correct, $score, 1 );
        
    }
    
}

function scoreRecursion( $answer, $question ) {
    
    $hasRecursion = $question->hasRecursion;
    
    if ( $hasRecursion == "1" ) {
        
        $description = "Recursion";
        $correct = false;
        $score = 0;
        
        $answerText = $answer->answer;
        
        $funcName = findFuncName( $answerText );
        
        if ( is_null( $funcName ) ) {
            $funcName = $question->functionName;
        }
        
        if ( !is_null( $funcName ) ) {
        
            $pos = strpos( $answerText, $funcName );
            $correct1 = $pos !== false;

            if ( $correct1 ) {
                
                $pos = strpos( $answerText, $funcName, $pos + strlen( $funcName ) );
                
                $correct = $pos !== false;
                
                if ( $correct ) {
                    $score = 1;
                }
                
            }

            addfeedback( $question, $description, $correct, $score, 1 );
        
        }
        
    }
    
}

function scoreKeyword( $answer, $question, $has, $keyword ) {
    if ( $has ) {
        $description = "Use " . $keyword . " statement";
        $correct = false;
        $score = 0;
        $answerText = $answer->answer;
        $pos = strpos( $answerText, $keyword );
        $correct = $pos !== false;
        if ( $correct ) {
            $score = 1;
        }
        addfeedback( $question, $description, $correct, $score, 1 );
    }
}

function scoreAnswer( $examScore, $answer ) {
    
    $argTypes = [];
    
    $answerArray = (array)$answer;
    
    $argTypes[] = $answerArray[ "argument1" ];
    $argTypes[] = $answerArray[ "argument2" ];
    $argTypes[] = $answerArray[ "argument3" ];
    $argTypes[] = $answerArray[ "argument4" ];
    
    $question = makeQuestion( $answer, $argTypes, 0, 0 );
    
    $examScore->questions[] = $question;
    
    scoreFuncName( $answer, $question );
    scoreRecursion( $answer, $question );
    scoreKeyword( $answer, $question, $question->hasIf == "1", "if" );
    scoreKeyword( $answer, $question, $question->hasWhile == "1", "while" );
    scoreKeyword( $answer, $question, $question->hasFor == "1", "for" );
    scoreCompilation( $answer, $question );
    scoreRun( $question );
    
    $examScore->score    = $examScore->score    + $question->score;
    $examScore->possible = $examScore->possible + $question->possible;
    
}

// input is json string
function scoreExam( $data ) {
    
    $input = json_decode($data);

    $results = callback( "studentExamAnswers.php", $data );
    $answers = json_decode($results);

    $examScore = makeExamScore( $input->ucid, $input->examId, 0, 0 );

    foreach ( $answers as $answer ) {
        scoreAnswer( $examScore, $answer );
    }
    
    $json = json_encode( $examScore );
    
    file_put_contents( "json.log", $json );
    
    return callback( "saveExamScore.php", $json );
    
}

?>