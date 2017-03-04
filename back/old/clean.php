<?php

// Create connection
$conn = include( "connect.php" );

echo "<br></br>";

$sql = "DELETE from cs490_ExamQuestions 
where QuestionId NOT IN (select Id from cs490_Questions)";

if ($conn->query($sql) === TRUE) {
    echo "All orphan data deleted.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
