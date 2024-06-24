<?php
if (isset($_POST['validate'])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $age = $_POST["age"];
    $password = $_POST["password"];
    $repassword = $_POST["confirm"];

    if (!empty($name) && !empty($username) && !empty($age) && !empty($password) && !empty($repassword)) {
        validateform($name,$username,$age,$password,$repassword);
    }else{
        echo("Please fill all fields");
    }
    
}

function validateform($name,$username,$age,$password,$repassword){
    $a=namevalidate($name);
    $b=unamevalidate($username);
    $c=agevalidate($age);
    $d=passvalidate($password,$repassword);
    if($a && $b && $c && $d==true){
        echo("Form Submitted succesfully");
    }

    if($a==false){
        echo "Your name is not correct";
    }
    if($b==false){
        echo "Your username is not correct";
    }
    if($c==false){
        echo "Your age is less then 16";
    }
    if($d==false){
        echo("password and retype password doesnt match");
    }


}

function namevalidate($name){
    $npatern="/[0-9\W]/";
    if(preg_match_all($npatern,$name)==0){
        return true;
    }else{
        return false;
    }
}
function unamevalidate($username){
    $upatern="/^[a-zA-Z].{7,}$/";
    if(preg_match_all($upatern,$username)!=0){
        return true;
    }else{
        return false;
    }
}
function agevalidate($age){
    if($age-16>=0){
        return true;
    }else{
        return false;
    }
}
function passvalidate($password,$repassword){
    if($password==$repassword){
        return true;
    }else{
        return false;
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
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name"></input></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username"></input></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input type="text" name="age"></input></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="text" name="password"></input></td>
            </tr>
            <tr>
                <td>Retype Password</td>
                <td><input type="text" name="confirm"></input></td>
            </tr>
            <tr>
                <td><input type="submit" name="validate" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>

</html>