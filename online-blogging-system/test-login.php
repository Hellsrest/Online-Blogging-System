<?php
if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $wrngpss = "
    <script>
        alert('Incorrect Password');
    </script>
";
    if ($conn->error) {
        echo ("No connection :(");
    }
    $sql = "select * from login where email='$email' and password='$password' ";
    $r = $conn->query($sql);
    if ($r && $r->num_rows > 0) {
        $row = $r->fetch_assoc();
        session_start();
        $_SESSION['id'] = $row['id'];
        $x = $row['id'];
        $_SESSION['username'] = $row['username'];
        $sql = "select * from account where uid=$x";
        $r = $conn->query($sql);
        $row = $r->fetch_assoc();
        $_SESSION['ppic'] = $row['ppic'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['query'] = "select p.*,a.username from posts p join account a on p.poster = a.uid where p.poster != '$x' and p.status != 'hide'";
        $_SESSION['dpagenum'] = 1;
        $_SESSION['apagenum'] = 1;
        header("Location:test-display.php?page-nr=1");
    } else {
        echo $wrngpss;
    }

}
?>


<html>

<head>
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <link rel="stylesheet" href="css\login.css">
</head>

<body id="main-body">
    <img src="imgs/verse.png" alt="no image found" id="mainlogo">
    <table id="login-table">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <tr>
                <td id="top-text">
                    Login
                </td>
            </tr>

            <tr>
                <td class="text">Email</td>
                <td><input type="email" name="email" class="text-fields"></td>
            </tr>
            <tr>
                <td class="text">Password</td>
                <td><input type="password" name="password" class="text-fields"></td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Login" name="Login" id="login-button">
                </td>
            </tr>
    </table>
    <a href="test-register.php" id="register-link">Register Now</a>
    <div id="form-container"></div>
    </form>
</body>

</html>