<?php
$file = fopen('images.jpg', 'r');
$data=fread($file, filesize('images.jpg'));
fclose($file);

$new=fopen('new.jpg','w');
fwrite($new, $data);
fclose($new);

echo("File copy is working");
?>
