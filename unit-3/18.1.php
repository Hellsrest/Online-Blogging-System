<?php
if(isset($_POST['age'])){
    $age=$_POST['agenum'];
    calcage($age);
}

function calcage($age){
    if($age>=18){
        echo("Welcome");
    }else{
        echo("You are restricted");
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
        <input type="text" name="agenum" value="enter your age"></input>
        <input type="submit" name="age" value="Submit">
    </form>
</body>

</html>