<!DOCTYPE html>
<html lang="en">
<?php
// Check if the "destroy" button is clicked
if (isset($_POST['destroy'])) {
    session_destroy();
    $cookie_name = "remember_me";
    setcookie($cookie_name, "", time() - 3600, "/"); 
    header('Location: 26.1.php');
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    echo ("User name is:".$_SESSION['uname']);
    ?>
</body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<p>Lab:26a, Name:Bisham Raj Pandey, Roll:15</p>
    <input type="submit" name="destroy" value="end session">
</form>

</html>