<?php
function abc(){
    echo("This is a function");
}

//default function
function ac($name="bisham"){
    echo("Hello".$name);
}

function value($a){
     $a+5;
}
$x=2;
abc();
echo("<br>");
ac("Bisham");
echo("<br>");
value(5);
value($x);
echo("<br>");
echo($x);
?>