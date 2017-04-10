<?php

/* 
 *     File:    testCompile
 *     Author:  Keith Grubbs
 *     Created: Apr 1, 2017
 */

include_once "scoring.php";

$results = "";

$result = compile( "test.java", $results );

?>

<html>
        
<body>
    
    <textarea cols="80" rows="10" readonly="true"><?= $results ?></textarea>
    
</body>

</html>
        
