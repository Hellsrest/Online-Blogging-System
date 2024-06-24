<?php

echo(date("y/M/D/l")."<br>");
echo(date("h:i:sa")."<br>");
$d=strtotime("next 10 decade");
echo date("Y-m-d h:i:sa",$d)
?>