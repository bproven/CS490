<?php

/* 
 *     File:        runTestCase.php
 *     Author:      Keith
 *     Created:     Mar 4, 2017
 *     Description: 
 *
 *	$data = trim(file_get_contents("php://input"));
 *	$answer = json_decode($data);
*/
//include_once "testcases.php";
$logic = " ";
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
	$feedback["Function Name"] = "Function named correctly.\n";
}
else{
	$score = 0;
	$feedback["Function Name"] = "Function named incorrectly.\n";
}
$Scores["Function Name Score"] = $score;
$totalScore += $score;
if ($logic == "while") {
  if(substr_count($answer, "while") > 0){
    $score = 1;
    $feedback["While Loop"] = "Function use while loop.\n";
  }
  else {
    $score = 0;
    $feedback["While Loop"] = "Function does not use while loop.\n";
  }
  $Scores["While Loop Score"] = $score;
  $totalScore = $score;
}
else if($logic == "for loop"){
  if(substr_count($answer, "for") > 0){
    $score = 1;
    $feedback["For Loop"] = "Function contains for loop.\n";
  }
  else{
    $score = 0;
    $feedback["For Loop"] = "Function contains no for loop.\n";
  }
  $Scores["For Loop Score"] = $score;
  $totalScore = $score;
}
else if ($logic == "recursion") {
  if(substr_count($answer, "$functionName") > 1){
    $score = 1;
    $feedback["Recursive"] = "Function uses recursion.\n";
  }
  else{
    $score = 0;
    $feedback["While Loop"] = "Function does not use recursion.\n";
  }
  $Scores["Recursion Score"] = $score;
  $totalScore = $score;
}
else if ($logic == "if statement") {
  if(substr_count($answer, "if") > 0){
    $score = 1;
    $feedback["If Statement"] = "Function has if statement.\n";
  }
  else {
    $score = 0;
    $feedback["If Statement"] = "Function has no if statement.\n";
  }
  $Scores["If Statement Score"] = $score;
  $totalScore = $score;
}
file_put_contents($file, "class test {\n\n"); //create Java file and write, append code
file_put_contents($file, $answer, FILE_APPEND);
file_put_contents($file, "\n\n", FILE_APPEND);
file_put_contents($file, "public static void main(String[] args) {\n", FILE_APPEND);
file_put_contents($file, "System.out.println(cubed($value));\n", FILE_APPEND);
file_put_contents($file, "}\n\n}", FILE_APPEND);
exec("javac test.java"); //compile Java
if(file_exists('test.class') == true){ //test if students' code compiled successfully
	$score = 1;
	$feedback["Compilation"] = "Function compiled correctly.\n";
}
else{
	$score = 0;
	$feedback["Compilation"] = "Function does not compile.\n";
}
$Scores["Compilation Score"] = $score;
$totalScore += $score;
$result = shell_exec("java test"); //run Java
if($result == $returnValue){ //test students' output with correct value
	$score = 1;
	$feedback["Output"] = "Your output is correct.\n";
}
else{
	$score = 0;
	$feedback["Output"] = "Your output is incorrect.\n";
}
$Scores["Output Score"] = $score;
$totalScore += $score;
$Scores["Total Score"] = $totalScore;

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