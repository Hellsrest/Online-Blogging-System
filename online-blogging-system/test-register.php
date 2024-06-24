<?php
date_default_timezone_set('UTC');
session_start();

if (isset($_POST['register']) && isset($_FILES["image"])) {
  echo "Form submitted successfully!";
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $username = $_POST['username'];
  $bio = $_POST['bio'];
  $role = "user";

  $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM login WHERE email='$email'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "Email already exists";
    $conn->close();
    exit;
  }
  $upload_error = $_FILES['image']['error'];
  if ($upload_error === UPLOAD_ERR_OK) {
    $upload = 'pimgs/';
    $maxsize = 1024 * 1024;
    $sizechecker = $_FILES['image']['tmp_name'];
    $imageinfo = getimagesize($sizechecker);
    $width = $imageinfo[0];
    $height = $imageinfo[1];
    if ($_FILES['image']['size'] > $maxsize) {
      echo "File size problem";
      $conn->close();
      exit;
    }
    $new_width = 1080;
    $new_height = 1080;
    $src = imagecreatefromjpeg($sizechecker);
    $dst = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    $compressed_filename = uniqid() . '.jpg';
    $compressed_path = $upload . $compressed_filename;

    if (imagejpeg($dst, $compressed_path, 100)) {
      $ppic = $compressed_path;

      $sql = "INSERT INTO login (email, password, date, username) VALUES ('$email', '$pass', NOW(), '$username')";
      if ($conn->query($sql) === TRUE) {
        $sql1 = "SELECT id FROM login WHERE email='$email'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        $userid = intval($row1['id']);
        $sql = "INSERT INTO account (uid, username, email, password, bio, ppic, date, role) VALUES ($userid, '$username', '$email', '$pass', '$bio', '$ppic', NOW(), '$role')";
        if ($conn->query($sql) === TRUE) {
          echo "User registered and image uploaded successfully.";
          header("Location: test-login.php");
          exit;
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        echo "    <script>
        alert('Incorrect Password');
    </script>";
      }
    } else {
      echo "Error compressing and saving the image.";
    }

    // Clean up resources
    imagedestroy($src);
    imagedestroy($dst);
  } else {
    echo "Error uploading file: " . $upload_error;
  }

  $conn->close();
}
?>



<html>

<head>
  <title>Verse: Register to the Site</title>
  <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
  <link rel="stylesheet" href="css\register.css">
</head>

<body id="main-body">
  <a href="test-login.php">
    <img src="imgs/verse.png" alt="no image found" id="mainlogo">
  </a>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

      <table id="maincontainer">
        <tr>
          <td id="top-text">Register</td>
        </tr>


        <tr>
          <td id="emailtext" class="text">Email</td>
          <td id="emailenter">
            <input type="text" name="email" id="emailfield" placeholder="Enter email" value="example@email.com"
              class="text-fields">
          </td>
          <td id="emailret" class="errorfield"></td>
        </tr>


        <tr>
          <td id="usernametext" class="text">Username</td>
          <td id="usernameenter">
            <input type="text" name="username" id="usernamefield" placeholder="Enter Username" class="text-fields">
          </td>
          <td id="usernameret" class="errorfield"></td>
          </td>
        </tr>

        <tr>
          <td id="passwordtext" class="text">Password</td>
          <td id="passwordenter">
            <input type="password" name="password" id="passwordfield" placeholder="Enter password" class="text-fields">
          </td>
          <td id="passwordret" class="errorfield"></td>
        </tr>


        <tr>
          <td id="biotext" class="text">Bio</td>
          <td id="bioenter">
            <input type="text" name="bio" id="biofield" class="text-fields" placeholder="Bio only 150 characters">
          </td>
          <td id="bioret" class="errorfield"></td>
        </tr>


        <tr>
          <td id="ppictext" class="text">
              Profile Picture
          </td>

          <td id="ppicenter">
              <input type="file" name="image" id="image-upload" accept="image/*">
              <div id="image-container" style="display: none;" class="text-fields">
                <img id="selected-image" alt="Selected Image">
              </div>
          </td>
        </tr>

        <tr>
          <td id="submit button">
              <input type="submit" name="register" value="Register" id="registerbtn">
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

</html>