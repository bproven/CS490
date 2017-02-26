<?php

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);

$examnum=($decoded->ExamNumber);
$qnum=($decoded->QuestionNumber);
$points=($decoded->Points);

// Create connection
$conn = include( "connect.php" );

$examnum    = mysqli_real_escape_string($conn, $examnum);
$qnum       = mysqli_real_escape_string($conn, $qnum);

echo "<br></br>";

$sql = "SELECT * FROM cs490_ExamQuestions";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
	if ( ($row["ExamId"] == $examnum) And ($row["QuestionId"] == $qnum) ) {
		echo "Duplicate Entry";
		exit();
	}
}

$sql = "INSERT INTO cs490_ExamQuestions
	VALUES ('".$examnum."', '".$qnum."', '".$points."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>