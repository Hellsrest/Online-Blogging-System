<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php $_server['php_self']?>" method="post">
    <input type="file" name="filetoupload">
<input type="submit">   
    </form>
<?php
if($_server['request_method']==['post']){
    echo($_files['filetoupload']['name']);
    echo($_files['filetoupload']['size']);
    echo($_files['filetoupload']['tyoe']);
}

?>
</body>
</html>