<?php

include "callback.php";

$question = (object) array(
    "question"      => "text",
    "argument1"     => "int",
    "argument2"     => "int",
    "argument3"     => null,
    "argument4"     => null,
    "returnType"    => "int",
    "difficulty"    => 3,
    "functionName"  => "sum",
    "hasIf"         => false,
    "hasWhile"      => false,
    "hasFor"        => false,
    "hasRecursion"  => false
);

echo callback( "addQuestion.php", $question );

?>