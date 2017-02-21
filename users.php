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

$sql = "SELECT * FROM cs490_Users";
$result = $conn->query($sql);
echo "<br></br>";
echo "<table>";
echo '<tr>';
echo "<td>"."<strong>"."UCID"."</strong>"."</td>";
echo "<td>"."<strong>"."Password"."</strong>"."</td>";
echo "<td>"."<strong>"."First"."</strong>"."</td>";
echo "<td>"."<strong>"."Last"."</strong>"."</td>";
echo "<td>"."<strong>"."Privelege"."</strong>"."</td></tr>";
while($row = $result->fetch_assoc()) {
	echo "<td>".$row["UCID"]."</td><td>";
	echo $row["Password"]."</td><td>";
	echo $row["First"]."</td><td>";
	echo $row["Last"]."</td><td>".$row["Privelege"]."</td></tr>";
}
echo '</tr>';
echo "<table>";
echo "<br></br>";

$conn->close();

?>