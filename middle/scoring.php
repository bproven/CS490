<?php

/*Keith temp middle beta CS490
  Students id and ezam Id ill be received as an encoded JSON object
  
    $studentCode = trim(file_get_contents("php://input"));
	$answer = json_decode($studentCode);
*/

function makeFeedback( $description, $correct, $score, $possible ) 
{
    return (object)array(
        "description"   => $description,
        "correct"       => $correct,
        "score"         => $score,
        "possible"      => $possible
    );
}

function makeQuestion( $questionId, $score, $possible )
{
    return (object) array(
        "questionId"    => $questionId,
        "score"         => $score,
        "possible"      => $possible,
        "feedback"      => []
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
    $description = "";
    
    if( $correct == true)
    { 
	$score = 1;
	$description = "Function named correctly";
    }   
    else{
	$score = 0;
	$description = "Function named incorrectly";
    }
    addfeedback($question, $description, $correct, $score, 1);
    
}

function scoreCompile_Execute( $answer, $question ) {
    
    $file = "test.java";
    $answerText = $answer->answer;
	$functionName = $answer -> functionName;
    $score = 0;
    $feedback = "";

// temp test    
    //$answerText = "public static int cubed(int number){return number * number * number;}"; //will be provided by student as their answer
    
    file_put_contents($file, "class test {\n\n"); //create Java file and write, append code
    file_put_contents($file, $answerText, FILE_APPEND);
    file_put_contents($file, "\n\n", FILE_APPEND);
    file_put_contents($file, "public static void main(String[] args) {\n", FILE_APPEND);
  
	if($functionName == "sum"){
		file_put_contents($file,"System.out.println($functionName(10,15));\n",FILE_APPEND);
	}
	else if($functionName == "subtract"){
		file_put_contents($file,"System.out.println($functionName(10,25));\n",FILE_APPEND);
	}
	else if($functionName == "squared"){
		file_put_contents($file,"System.out.println($functionName(10));\n",FILE_APPEND);
	}
	else if($functionName == "factorial"){
		file_put_contents($file,"System.out.println($functionName(7));\n",FILE_APPEND);
	}
    file_put_contents($file, "}\n\n}", FILE_APPEND);
    $compiled = "test.class";
    
    if ( file_exists( $compiled ) == true ){
        unlink( $compiled );
    }
    
    exec("javac test.java"); //compile Java
    
    $correct = file_exists($compiled) == true;   //test if students' code compiled successfully
    
    if( $correct == true ) { 
        $score = 1;
        $feedback = "Function compiled correctly";
    }
    else{
        $score = 0;
        $feedback = "Function does not compile.";
    }
    $output = shell_exec("java test"); //execute code
	//echo " $functionName is $output, "; output directly to browser for testing when I run scoreExam.php
	if(isset($output)){
		$score += 1;
		$feedback .= ", Function ran successfully.";
	}
	else{
		$score += 0;
		$feedback .= ", Function did not run successfully.";
	}
	
    addfeedback($question, $feedback, $correct, $score, 1);

}

function scoreAnswer( $examScore, $answer ) {
    
    $question = makeQuestion( $answer->questionId, 0, 0 );
    $examScore->questions[] = $question;
    
    scoreFuncName( $answer, $question );
    scoreCompile_Execute($answer, $question);
    
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
    
    return callback( "saveExamScore.php", json_encode( $examScore ) );
    
}

?>