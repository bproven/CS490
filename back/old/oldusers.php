<?php

// Create connection
$conn = include( "connect.php" );

$sql = "select * from cs490_Users";

if ( $result = $conn->query( $sql ) ) {

?>

<br>
<table>
    <thead>
        <tr>
            <td>UCID</td>
            <td>Password></td>
            <td>First</td>
             <td>Last</td>
            <td>Privelege</td>
        </tr>
    </thead>
    <tbody>
        
<?php

    while ( $user = $result->fetch_object() ) {
        echo "<tr>";
        echo "<td>" . $user->UCID       . "</td>";
        echo "<td>" . $user->Password   . "</td>";
        echo "<td>" . $user->First      . "</td>";
        echo "<td>" . $user->Last       . "</td>";
        echo "<td>" . $user->Privelege  . "</td>";
        echo "</tr>";
    }

}

$conn->close();

?>

        </tbody>
    </table>
<br>
