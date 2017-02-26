<?php

//Using MySql Server on AFS, with table named UCID

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content);

$id   = $decoded->UCID;
$pass = $decoded->password;

$flag = false;

// Create connection
$conn = include( "connect.php" );

$sql = "SELECT Id, Password FROM cs490_Users";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
	//echo "UCID: " . $row["Id"] . str_repeat('&nbsp;', 5) ."Password: ". $row["Password"]."<br></br>";
	if ( ($id == $row["Id"]) and ($pass == $row["Password"]) ){
		$flag = true;
        break;
	}
}
 
$conn->close();

$data = array("result" => $flag);
$data_string = json_encode($data);
header("Content-Type:application/json");
echo $data_string;

?>