<?php

/*Keith temp middle beta CS490
  Students' code will be received as an encoded JSON object
  
    $studentCode = trim(file_get_contents("php://input"));
	$answer = json_decode($studentCode);
*/

include( "callback.php" );

function makeFeedback( $description, $correct, $score ) 
{
    return (object)array(
        "description"   => $description,
        "correct"       => $correct,
        "score"         => $score
    );
}

function makeQuestion( $questionId, $score )
{
    return (object) array(
        "questionId"    => $questionId,
        "score"         => $score,
        "feedback"      => []
    );
}

function makeExamScore( $ucid, $examId, $grade ) 
{
    return (object) array(
        "ucid"      => $ucid,
        "examId"    => $examId,
        "grade"     => $grade,
        "questions" => []
    );
}

function addfeedback( $question, $description, $correct, $score ) {
    
    $feedback = makeFeedback( $description, $correct, $score );
    
    $question->score = $question->score + $score;
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
    
    addfeedback($question, $description, $correct, $score);

}

function scoreCompilation( $answer, $question ) {
    
    $file = "test.java";
    $answerText = $answer->answer;
    $score = 0;
    $feedback = "";
    
    file_put_contents($file, "class test {\n\n"); //create Java file and write, append code
    file_put_contents($file, $answerText, FILE_APPEND);
    file_put_contents($file, "\n\n", FILE_APPEND);
    file_put_contents($file, "public static void main(String[] args) {\n", FILE_APPEND);
    file_put_contents($file, "System.out.println(cubed($value));\n", FILE_APPEND);
    file_put_contents($file, "}\n\n}", FILE_APPEND);
    
    exec("javac test.java"); //compile Java
    
    $correct = file_exists('test.class') == true;   //test if students' code compiled successfully
    
    if( $correct == true ) { 
        $score = 1;
        $feedback = "Function compiled correctly";
    }
    else{
        $score = 0;
        $feedback = "Function does not compile.";
    }

    addfeedback($question, $description, $correct, $score);

}

function scoreAnswer( $examScore, $answer ) {
    
    $question = makeQuestion( $answer->questionId, 0 );

    $examScore->questions[] = $question;
    
    scoreFuncName( $answer, $question );
    scoreCompilation($answer, $question);
    
    $examScore->grade = $examScore->grade + $question->score;
    
}

//$data = trim(file_get_contents("php://input"));
$data = '{ "ucid": "rap9", "examId": 1 }';
$input = json_decode($data);

$results = callback( "studentExamAnswers.php", $data );
$answers = json_decode($results);

$examScore = makeExamScore( $input->ucid, $input->examId, 0 );

foreach ( $answers as $answer ) {
    scoreAnswer( $examScore, $answer );
}

$Scores = array();
$feedback = array();
$score = 0;
$totalScore = 0;
$file = "test.java";
$functionName = 'cubed';
$value = 10;
$returnValue = 1000;
$answer = "public static int cubed(int number){return number * number * number;}"; //will be provided by student as their answer
if(strpos($answer, $functionName) == true){ //test if student named function correctly
	$score = 1;
	//echo "Your function is named correctly, $score point for this part.\n";
	$feedback["Function Name"] = "Function named correctly.\n";
}
else{
	$score = 0;
	//echo "Your function is named incorrectly, $score point for this part.\n";
	$feedback["Function Name"] = "Function named incorrectly.\n";
}
//$funcNameScore = $score;
$Scores["Function Name Score"] = $score;
$totalScore += $score;
file_put_contents($file, "class test {\n\n"); //create Java file and write, append code
file_put_contents($file, $answer, FILE_APPEND);
file_put_contents($file, "\n\n", FILE_APPEND);
file_put_contents($file, "public static void main(String[] args) {\n", FILE_APPEND);
file_put_contents($file, "System.out.println(cubed($value));\n", FILE_APPEND);
file_put_contents($file, "}\n\n}", FILE_APPEND);
exec("javac test.java"); //compile Java
if(file_exists('test.class') == true){ //test if students' code compiled successfully
	$score = 1;
	//echo "Code compiles, you scored $score point for this part.\n";
	$feedback["Compilation"] = "Function compiled correctly.\n";
}
else{
	$score = 0;
	//echo "Code does not compile, you scored $score point for this part.\n";
	$feedback["Compilation"] = "Function does not compile.\n";
}
$Scores["Compilation Score"] = $score;
$totalScore += $score;
$result = shell_exec("java test"); //run Java
if($result == $returnValue){ //test students' output with correct value
	$score = 1;
	//echo "Your output value for this question is $result";
	//echo "This is correct.\n";
	//echo "You scored $score point for this part.\n";
	$feedback["Output"] = "Your output is correct.\n";
}
else{
	$score = 0;
	//echo "Your output value for this question is $result"; 
	//echo "This is not the correct answer.\n";
	//echo "You scored $score point for this part.\n";
	$feedback["Output"] = "Your output is incorrect.\n";
}
$Scores["Output Score"] = $score;
$totalScore += $score;
$Scores["Total Score"] = $totalScore;
//echo "Your total score for this question is $totalScore points.\n";

foreach($Scores as $item => $contents){
	echo "$item: $contents\n";
}
echo "\n";
 foreach($feedback as $item => $contents){
	echo "$item: $contents";
}
$DanURL = "http://afs1access.njit.edu/~dhg6/cs490/back.php";
//student scores
$score_string = json_encode($Scores); 
                                                                                  
	$ch = curl_init($DanURL);                                                                      
	curl_setopt($ch, CURLOPT_POST, 1);                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $score_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($score_string))                                                                       
	);                                                                                                                   
	$student_score = curl_exec($ch);
	curl_close($ch);

//student feedback
$feedback_string = json_encode($feedback); 
                                                                                  
	$ch = curl_init($DanURL);                                                                      
	curl_setopt($ch, CURLOPT_POST, 1);                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $feedback_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($feedback_string))                                                                       
	);                                                                                                                   
	$student_feedback = curl_exec($ch);
	curl_close($ch);
?>