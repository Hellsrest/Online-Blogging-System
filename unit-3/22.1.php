<?php
if(isset($_POST['view'])){
    readsfile();
}

if(isset($_POST['write'])){
    $x=$_POST['input'];
    writesfile($x);
}
function readsfile(){
    $file = fopen('file.txt', 'r');
    if ($file) {
        while (($char = fgetc($file)) != false) {
            echo ($char);
        }
        fclose($file);
    } else {
        echo 'Error opening file.';
    }
}

function writesfile($x)
{
    $file = fopen('file.txt', 'w');
    if ($file) {
        $string = $x;
        for ($i = 0; $i < strlen($string); $i++) {
            fputs($file,$string[$i]);
        }
        fclose($file);
    } else {
        echo 'Error opening file.';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="text" name="input"></input>
        <input type="submit" name="write" value="Submit"><br/>

        <input type="submit" name="view" value="view">
    </form>
</body>

</html>