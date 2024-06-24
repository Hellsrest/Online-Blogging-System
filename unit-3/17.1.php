<?php
if(isset($_POST['multiply'])){
$a=$_POST['fn'];
$b=$_POST['sn'];
$x=1;
if($a>=$b){
    $c=$a;
}else{
    $c=$b;
}

while($x!=11){
    $mul=$c*$x;
    echo($c."*".$x."=".$mul."<br/>");
    $x++;
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
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <input type="text" name="fn" value="enter first number"></input>
    <input type="text" name="sn" value="enter second number"></input>
    <input type="submit" name="multiply" value="Submit">
    <p> Lab No.: 1  Name: Bisham Raj Pandey Roll No=15 Section : A </p>
</form>
</body>
</html>