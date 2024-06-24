<?php
$associative1=array(
    "english"=>50,
    "math"=>60,
    "science"=>70,
    "nepali"=>80,
);

$associative2["english"]=80;
$associative2["math"]=70;
$associative2["science"]=60;
$associative2["nepali"]=50;

$subject = array_keys($associative1);  
$marks = count($associative1);   
//echo($subject);
//echo($marks);
echo("using for loop:<br/>");
for($i=0;$i<$marks;$i++){
    echo $subject[$i] . ':' . $associative1[$subject[$i]] . "<br/>";   
}
echo("<br/>");
echo("using foreach loop:<br/>");
foreach($associative2 as $subject=>$marks){
    echo $subject.":".$marks."<br/>";
}


?>