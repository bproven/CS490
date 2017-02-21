<?php
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);
$question=($decoded->Question);
$function_name=($decoded->FunctionName);
$arg1=($decoded->Argument1);
$arg2=($decoded->Argument2);
$arg3=($decoded->Argument3);
$arg4=($decoded->Argument4);
$difficulty=($decoded->Difficulty);
$answer=($decoded->Answer);
$hasIf=($decoded->HasIf);
$hasWhile=($decoded->HasWhile);
$hasFor=($decoded->HasFor);
$servername = "sql2.njit.edu";
$username = "dhg6";
$password = "VkwQg0fD";
$dbname = "dhg6";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$question=mysqli_real_escape_string($conn, $question);
$function_name=mysqli_real_escape_string($conn, $function_name);
$arg1=mysqli_real_escape_string($conn, $arg1);
$arg2=mysqli_real_escape_string($conn, $arg2);
$arg3=mysqli_real_escape_string($conn, $arg3);
$arg4=mysqli_real_escape_string($conn, $arg4);
$difficulty=mysqli_real_escape_string($conn, $difficulty);
$answer=mysqli_real_escape_string($conn, $answer);
$hasIf=mysqli_real_escape_string($conn, $hasIf);
$hasWhile=mysqli_real_escape_string($conn, $hasWhile);
$hasFor=mysqli_real_escape_string($conn, $hasFor);

echo "<br></br>";

$sql = "INSERT INTO cs490_Questions (Question, FunctionName, Argument1, Argument2,
	Argument3, Argument4, Difficulty, HasIf, HasWhile, HasFor, Answer)
	VALUES ('".$question."', '".$function_name."', '".$arg1."', '".$arg2."', 
	'".$arg3."', '".$arg4."', '".$difficulty."', '".$hasIf."', '".$hasWhile."', 
	'".$hasFor."', '".$answer."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>