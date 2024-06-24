<?php
session_start();
if(isset($_SESSION['uname'])) {
    header("Location: welcome.php");
    exit();
}
function validate_user($uname, $pw) {
    $user = array(
        'bsm' => 'bsm',
    );

    if(array_key_exists($uname, $user) && $user[$uname] === $pw) {
        return true;
    } else {
        return false;
    }
}

// Check if the login form is submitted
if(isset($_POST['login'])) {
    $uname = $_POST['uname'];
    $pw = $_POST['pw'];
    $remember = isset($_POST['remember']);

    // Validate user credentials
    if(validate_user($uname, $pw)) {
        $_SESSION['uname'] = $uname;

        // Set cookie for "remember me" feature if checked
        if($remember) {
            $cookie_name = 'remember_me';
            $cookie = base64_encode($uname . '|' . $pw);
            setcookie($cookie_name, $cookie, time() + (86400 * 30), "/"); // 30 days
        }

        header("Location: welcome.php");
        exit();
    } else {
        echo("Enter correct username and password");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <form method="post" action="">
        Username: <input type="text" name="uname"><br><br>
        Password: <input type="pw" name="pw"><br>
        Remember Me: <input type="checkbox" name="remember"><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
