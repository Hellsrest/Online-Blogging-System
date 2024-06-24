<?php
if(isset($_POST['submit'])){
    $uname=$_POST['uname'];
    $pwrd=$_POST['password'];
    if(empty($uname)){
        echo("name cant be mt");
    }else if(strlen($pwrd)<6){
        echo("password must be greater then 6 chars");
    }elseif($uname==$pwrd){
        echo("name and pswrd cant be same");
    }else{
        echo(trim($uname)."<br>");
        echo(trim($pwrd));
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
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="uname"></td>
            </tr>
            <tr>
                <td>password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>