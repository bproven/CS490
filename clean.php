<?php
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
