<!DOCTYPE html>

<html>
    
    <head>

 	<link rel="stylesheet" type="text/css" href="front.css">
	<title>CS490 Login Page</title>
	<meta charset = "utf-8" />
        
    </head>
    
    <body>

	<div class=main>
        
        <h1>CS 490 Project </h1>
       
	<form action="front.php" method="post">
		<fieldset>
		Write a function called <input type="text" name="FunctionName">
		that <input type="text" name="Question">
		using arguments 1:<input type="text" name="Argument1">
		2:<input type="text" name="Argument2">
		3:<input type="text" name="Argument3">
		4:<input type="text" name="Argument4">.
		Difficulty: <input type="text" name="Difficulty">.
		<br></br>Answer:<br></br>
			<textarea name="Answer"></textarea><br></br>
		Has If Statement? (n for no, y for yes) <input type="text" name="HasIf">
		Has While Loop? (n for no, y for yes)<input type="text" name="HasWhile">
		Has For Loop? (n for no, y for yes)<input type="text" name="HasFor"><br></br>
		<button type="submit" value="Submit" name="Insert">Insert Question</button>
		<button type="reset" value="Reset">Reset</button>
		</fieldset>
	</form>

	<form action="front.php" method="post">
		<fieldset>
		Add into Exam Number <input type="text" name="ExamNumber">
		, question ID# <input type="text" name="QuestionNumber">
		. Points assigned to question: <input type="text" name="Points">
		<button type="submit" value="AddQuestion" name="AddQuestion">Add Question</button>
		<button type="reset" value="Reset">Reset</button>
		</fieldset>
	</form>	



	<br></br>
	<form action="front.php" method="post">
		<button type="submit" value="ViewUsers" name="ViewUsers">View Users</button>
		<button type="submit" value="ViewQuestions" name="ViewQuestions">View Questions</button>
		<button type="submit" value="ViewExams" name="ViewExams">View Exams</button>
		<button type="submit" value="ViewGrades" name="ViewGrades">View Grades</button>
		<button type="submit" value="Clean" name="Clean">Clean Database</button>
	</form>
	


<?php
	function viewUsers() {
		$URL = "https://web.njit.edu/~dhg6/cs490/users.php";        
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	function viewQuestions() {
		$URL = "https://web.njit.edu/~dhg6/cs490/questions.php";        
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	function viewExams() {
		$URL = "https://web.njit.edu/~dhg6/cs490/exams.php";        
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	function viewGrades() {
		$URL = "https://web.njit.edu/~dhg6/cs490/grades.php";        
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}
	function insert(){
		$URL = "https://web.njit.edu/~dhg6/cs490/insert.php";
		$data = array( 'Question' => ($_POST["Question"]), 'FunctionName' => ($_POST["FunctionName"]), 
			'Argument1' => ($_POST["Argument1"]), 'Argument2' => ($_POST["Argument2"]), 
			'Argument3' => ($_POST["Argument3"]), 'Argument4' => ($_POST["Argument4"]),
			'Difficulty' => ($_POST["Difficulty"]), 'Answer' => ($_POST["Answer"]),
			'HasIf' => ($_POST["HasIf"]), 'HasWhile' => ($_POST["HasWhile"]),
			'HasFor' => ($_POST["HasFor"]) );
                                       
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	function add(){
		$URL = "https://web.njit.edu/~dhg6/cs490/add.php";
		$data = array( 'ExamNumber' => ($_POST["ExamNumber"]), 'QuestionNumber' => ($_POST["QuestionNumber"]),
		'Points' => ($_POST["Points"]) );                 
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	function clean() {
		$URL = "https://web.njit.edu/~dhg6/cs490/clean.php";        
		$data_string = json_encode($data);                                                                                   
		$ch = curl_init($URL);                                                                      
		curl_setopt($ch, CURLOPT_POST, 1);                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}

	if(isset($_POST['Insert'])) {
		insert();
	} 	
	if(isset($_POST['ViewUsers'])) {
		viewUsers();
	}
	if(isset($_POST['ViewQuestions'])) {
		viewQuestions();
	}
	if(isset($_POST['ViewGrades'])) {
		viewGrades();
	}
	if(isset($_POST['ViewExams'])) {
		viewExams();
	}
	if(isset($_POST['AddQuestion'])) {
		add();
	}
	if(isset($_POST['Clean'])) {
		clean();
	} 
?>

	</div>
    </body>
    
</html>