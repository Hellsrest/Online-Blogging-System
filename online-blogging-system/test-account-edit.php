<?php
include 'test-header.php';
//session_start();
?>
<?php
date_default_timezone_set('UTC');
if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $sql = "select * from account where uid ='$id'";
    $r = $conn->query($sql);
    $row = $r->fetch_assoc();
    $uid = ($row['uid']);
    $username = ($row['username']);
    $email = ($row['email']);
    $password = ($row['password']);
    $bio = ($row['bio']);
    $imageurl = $row["ppic"];
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    //$img = $_POST['uimage'];
    $uname = ($_POST['uname']);
    $password = ($_POST['pass']);
    $email = ($_POST['email']);
    $bio = ($_POST['bio']);
    $targetdir = "pimgs/";
    $targetfile = $targetdir . basename($_FILES["image"]["name"]);
    $url = "test-account-edit.php?id=" . $id;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetfile)) {
            $conn = new mysqli("localhost:3307", "root", "", "test-database");
            $sql = "update account set username = '$uname', email = '$email', password = '$password',bio='$bio',ppic='$targetfile' where uid = $id;";
            $r = $conn->query($sql);
            $sql = "update login set email = '$email', password = '$password',username = '$uname' where id = $id;";
            $r = $conn->query($sql);
            echo ("edited successfully");
            header("location:test-display.php");
            header("Location: $url");
        } else {
            echo "error 1";
        }
    } else {
        $targetfile = $_POST['hidddenimg'];
        $url = "test-account-edit.php?id=" . $id;
        $conn = new mysqli("localhost:3307", "root", "", "test-database");
        $sql = "update account set username = '$uname', email = '$email', password = '$password',bio='$bio',ppic='$targetfile' where uid = $id;";
        $r = $conn->query($sql);
        $sql = "update login set email = '$email', password = '$password',username = '$uname' where id = $id;";
        $r = $conn->query($sql);
        echo ("edited successfully");
        header("location:test-display.php");
        header("Location: $url");

    }
}


if (isset($_POST['finalsolution'])) {
    $id = $_GET['id'];
    $url = "test-login.php";
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $sql = "delete from account where uid='$id';";
    $r = $conn->query($sql);
    $sql = "delete from login where id='$id';";
    $r = $conn->query($sql);
    $sql = "delete from comment where uid='$id';";
    $r = $conn->query($sql);
    $sql = "delete from follower where sender='$id';";
    $r = $conn->query($sql);
    $sql = "delete from follower where receiver='$id';";
    $r = $conn->query($sql);
    $sql = "delete from likes where uid='$id';";
    $r = $conn->query($sql);
    $sql = "delete from messages where sid='$id';";
    $r = $conn->query($sql);
    $sql = "delete from messages where rid='$id';";
    $r = $conn->query($sql);
    $sql = "delete from posts where poster='$id';";
    $r = $conn->query($sql);
    echo ("You Are Now Free");
    header("location:test-login.php");
    header("Location: $url");
    exit;
}

?>
<html>

<head>
    <title>Edit Your Account</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <link rel="stylesheet" href="css\account-edit.css">
</head>

<body id="main-body">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    <?php echo '<input  type="hidden" name="id" value="' . $id . '">' ?>


        <table id="maincontainer">
            <tr>
                <td id="top-text">Edit Profile</td>
            </tr>


            <tr>
                <td id="emailtext" class="text">Email</td>
                <td id="emailenter">
                    <input type="text" name="email" id="emailfield" value="<?php echo $email; ?> "
                        placeholder="Enter email" class="text-fields">
                </td>
                <td id="emailret" class="errorfield"></td>
            </tr>


            <tr>
                <td id="usernametext" class="text">Username</td>
                <td id="usernameenter">
                    <input type="text" name="uname" id="usernamefield" placeholder="Enter Username" class="text-fields"
                        value="<?php echo $username; ?> ">
                </td>
                <td id="usernameret" class="errorfield"></td>
                </td>
            </tr>

            <tr>
                <td id="passwordtext" class="text">Password</td>
                <td id="passwordenter">
                    <input type="text" name="pass" value="<?php echo $password; ?>" id="passwordfield"
                        placeholder="Enter password" class="text-fields">
                </td>
                <td id="passwordret" class="errorfield"></td>
            </tr>


            <tr>
                <td id="biotext" class="text">Bio</td>
                <td id="bioenter">
                    <input type="text" name="bio" id="biofield" class="text-fields"
                        placeholder="Bio only 150 characters" value="<?php echo $bio; ?>">
                </td>
                <td id="bioret" class="errorfield"></td>
            </tr>


            <tr>
                <td id="ppictext" class="text">
                    Profile Picture
                </td>

                <td id="ppicenter">
                    <div id="picture-picture">
                    <?php echo '<input type="text" name="hidddenimg" value="' . $imageurl . '"   > hidden'; ?>


                        <?php echo '<img id="selected-image" src="' . $imageurl . '" alt="Image"  >'; ?>
                        </input>
                    </div>

                    <input type="file" name="image" id="image-upload" accept="image/*">

                </td>
            </tr>

            <tr>
                <td id="submit button">
                    <input type="submit" name="edit" value="edit" id="registerbtn">
                </td>
            </tr>

            <tr>
                <td id="delete button">
                    <input type="submit" name="finalsolution" value="delete account" id="deletebtn">
                </td>
            </tr>

        </table>
    </form>
</body>

<script>
    var allowsub = 0;
    var maxAllowsub = 4;

    document.getElementById('image-upload').addEventListener('change', function () {
        var fileInput = document.getElementById('image-upload');
        var imageContainer = document.getElementById('image-container');
        var imageElement = document.getElementById('selected-image');

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function (event) {
                var img = new Image();
                img.onload = function () {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var targetWidth = 1080; // Desired width
                    var targetHeight = 1080; // Desired height
                    canvas.width = targetWidth;
                    canvas.height = targetHeight;

                    // Resize the image to 1080x1080
                    ctx.drawImage(img, 0, 0, targetWidth, targetHeight);

                    // Get the resized image data as a data URL
                    var resizedImageDataURL = canvas.toDataURL('image/jpeg');

                    imageElement.src = resizedImageDataURL;
                    imageContainer.style.display = 'block';
                };
                img.src = event.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            imageElement.src = '';
            imageContainer.style.display = 'none';
        }
    });

    document.getElementById("emailfield").addEventListener("input", function () {
        var email = this.value;
        var emailret = document.getElementById("emailret");
        var isValidEmail = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email);

        if (email === "") {
            emailret.innerHTML = "<span style='color: red;'>Please enter Correct Email</span>";
        } else if (isValidEmail) {
            emailret.innerHTML = "<span style='color: green;'>&#10004; Valid Email</span>";
            allowsub++;
            toggleSubmitButton();
        } else {
            emailret.innerHTML = "<span style='color: red;'>&#10006; Invalid Email</span>";
        }
    });

    document.getElementById("usernamefield").addEventListener("input", function () {
        var username = this.value;
        var usernameret = document.getElementById("usernameret");
        var isValidUsername = /^(?=.*\d).{3,}$/.test(username);

        if (username === "") {
            usernameret.innerHTML = "<span style='color: red;'>Please enter Correct Username</span>";
        } else if (isValidUsername) {
            usernameret.innerHTML = "<span style='color: green;'>&#10004; Valid Username</span>";
            allowsub++;
            toggleSubmitButton();
        } else {
            usernameret.innerHTML = "<span style='color: red;'>&#10006; Invalid Username</span>";
        }
    });

    document.getElementById("passwordfield").addEventListener("input", function () {
        var password = this.value;
        var passwordret = document.getElementById("passwordret");
        var isValidPassword = /^(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/.test(password);

        if (password === "") {
            passwordret.innerHTML = "<span style='color: red;'>Please enter Correct Password</span>";
        } else if (isValidPassword) {
            passwordret.innerHTML = "<span style='color: green;'>&#10004; Valid Password</span>";
            allowsub++;
            toggleSubmitButton();
        } else {
            passwordret.innerHTML = "<span style='color: red;'>&#10006; Invalid Password</span>";
        }
    });

    document.getElementById("biofield").addEventListener("input", function () {
        var bioText = this.value;
        var bioCount = bioText.trim().length;
        var maxWords = 150;
        var bioret = document.getElementById("bioret");

        if (bioText === "") {
            bioret.innerHTML = "<span style='color: red;'>Please enter a bio</span>";
        } else {
            bioret.innerHTML = "";
        }
        if (bioCount > maxWords) {
            this.value = this.value.substring(0, maxWords);
            bioCount = maxWords;
        }
        allowsub++;
        toggleSubmitButton();
        bioret.textContent = bioCount + " / " + maxWords + " characters";
    });

    function toggleSubmitButton() {
        var submitButton = document.querySelector('input[type="submit"]');
        if (allowsub >= maxAllowsub) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }


</script>