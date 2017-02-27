<?php

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);

// Create connection
$conn = include( "connect.php" );

echo "<br></br>";

$sql = "select * from cs490_Questions";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	$count=4;
	if ( $row["Argument1"]===NULL Or $row["Argument1"]==="" ) { $count = ($count-1);}
	if ( $row["Argument2"]===NULL Or $row["Argument2"]==="" ) { $count = ($count-1);}
	if ( $row["Argument3"]===NULL Or $row["Argument3"]==="" ) { $count = ($count-1);}
	if ( $row["Argument4"]===NULL Or $row["Argument4"]==="" ) { $count = ($count-1);}
	echo "Question ID#".$row["Id"].": Write a function called ".$row["FunctionName"];
	echo " that ".$row["Question"].", using ";
	echo $count." arguments";
	if ( $count >0 ) { echo " called "; }
	if ( $row["Argument1"]!=NULL ) { echo $row["Argument1"] . ", "; }
	if ( $row["Argument2"]!=NULL ) { echo $row["Argument2"] . ", "; }
	if ( $row["Argument3"]!=NULL ) { echo $row["Argument3"] . ", "; }
	if ( $row["Argument4"]!=NULL ) { echo $row["Argument4"] . ", "; }
	echo " in the space provided.";
	if ( $row["HasIf"] == 'y' ) { echo " You must use an if statement."; }
	if ( $row["HasWhile"] == 'y' ) { echo " You must use a while loop."; }
	if ( $row["HasFor"] == 'y' ) { echo " You must use a for loop."; }

	echo "<br></br>";
	echo "Answer: ".$row["Answer"];
	echo "<br></br>";
	echo "Difficulty: ".$row["Difficulty"];
	echo "<br></br>"."<br></br>";
}


$conn->close();

?>