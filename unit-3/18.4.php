<?php
function tensum(&$numf) {
    $numf += 10;
    echo("The number afters function call in function:".$numf."<br>");
  }
  
  $num = 5;
  echo("The number before function call  outside function:".$num."<br>");
  tensum($num);
  echo("The number after function call outside function:".$num."<br>");
?>