<?php
$file=fopen('file.txt','r');
$data=fread($file, filesize('file.txt'));
$pattern = "/\b[tT]\w*/";
$data=preg_replace($pattern,"HEHE",$data);

$new=fopen('file.txt','w');
fwrite($new,$data);
fclose($new);

echo("the text may or maynot have been replaced");
?>