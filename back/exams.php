<?php

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);

$qnum = 1;
$flag = 0;

// Create connection
$conn = include( "connect.php" );

echo "<br></br>";

$sql = "SELECT * FROM cs490_Questions, cs490_ExamQuestions
	WHERE cs490_Questions.Id = cs490_ExamQuestions.QuestionId
	ORDER BY ExamId";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	if ( $flag !== $row["ExamId"] ) { $qnum = 1; }
	$count=4;
	if ( $row["Argument1"]===NULL Or $row["Argument1"]==="" ) { $count = ($count-1);}
	if ( $row["Argument2"]===NULL Or $row["Argument2"]==="" ) { $count = ($count-1);}
	if ( $row["Argument3"]===NULL Or $row["Argument3"]==="" ) { $count = ($count-1);}
	if ( $row["Argument4"]===NULL Or $row["Argument4"]==="" ) { $count = ($count-1);}
	if ( $qnum===1 ) { echo "<strong>"."Exam #".$row["ExamId"]."</strong>"."<br><br>"; }
	echo "Question #" . $qnum . ", ID#" . $row["Id"] . ": "."Write a function called ".$row["FunctionName"];
	$qnum=($qnum+1);
	echo " that ".$row["Question"].", using ";
	echo $count." arguments";
	if ( $count >0 ) { echo " called "; }
	if ( $row["Argument1"]!=NULL ) { echo $row["Argument1"] . ", "; }
	if ( $row["Argument2"]!=NULL ) { echo $row["Argument2"] . ", "; }
	if ( $row["Argument3"]!=NULL ) { echo $row["Argument3"] . ", "; }
	if ( $row["Argument4"]!=NULL ) { echo $row["Argument4"] . ", "; }
	echo " in the space provided.";
	echo "<br></br>";
	echo "Answer: ".$row["Answer"];
	echo "<br></br>";
	echo "Difficulty: ".$row["Difficulty"]. str_repeat('&nbsp;', 5);;
	echo "Points: ".$row["Points"];
	echo "<br></br>";

	$flag = $row["ExamId"];
}


$conn->close();

?>