
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style/login.css" />
  </head> 
  <body>

    <div class="input-group">
    <?php
if (isset($_GET['msg'])) {
    $message = htmlspecialchars($_GET['msg']);
    echo "<script>alert('Registration Successful');</script>";
}
?>
     <form method="post" action="validate_user.php">
        <p>Login to SeatiGenius</p>
        <input
          id="username"
          class="input"
           type="email"
          name="username"
        />
        <label class="label" for="username" name="username">Email</label
        ><br /><br />
        <input
          id="pwd"
          class="input1"
          type="password"
          name="password"
        /><br />
        <br />
        <label class="label1" for="password" name="password">Password</label>
        <button class="btn" type="submit"  name="login">Login</button>

        <p id="p1">Don't have an account?</p>
        <button class="btn1">
          <a href="./student/std_register.html">Register as Student</a>
        </button>
        <button class="btn2">
          <a href="./invigilator/invigilator_register.html">Register as Invigilator</a>
        </button>
      </form>
    </div>
  </body>
</html>

