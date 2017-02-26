<?php

// Create connection
$conn = include( "connect.php" );

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
