<?php
function sum($numarr) {
    $count = count($numarr);
    sort($numarr); 
    $small = $numarr[0]; 
    $large = $numarr[$count - 2]; 
    $sum = $small + $large; 
    echo "Sum is " . $sum;

    
}
$numarr = array(1, 2, 3, 4, 5);
sum($numarr); 
?>