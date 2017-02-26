<?php

// Create connection
$conn = include( "connect.php" );

echo "<br></br>";

$sql = "DELETE FROM cs490_ExamQuestions 
WHERE QuestionId NOT IN (SELECT Id FROM cs490_Questions)";

if ($conn->query($sql) === TRUE) {
    echo "All orphan data deleted.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
