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

$sql = "SELECT * FROM cs490_ExamGrades";
$result = $conn->query($sql);
echo "<table>";
echo "<tr>";
echo "<td>"."<strong>"."UCID"."</strong>"."</td>";
echo "<td>"."<strong>"."Exam Id"."</strong>"."</td>";
echo "<td>"."<strong>"."Grade"."</strong>"."</td></tr>";
while($row = $result->fetch_assoc()) {
	echo "<td>".$row["UCID"]."</td>";
	echo "<td>".$row["ExamId"]."</td>";
	echo "<td>".$row["Grade"]."</td>";	
}
echo "</tr>";
echo "<table>";
echo "<br></br>";

$conn->close();

?>
