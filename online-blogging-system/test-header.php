<?php
session_start();
$upload = 'pimgs/';
$conn = new mysqli("localhost:3307", "root", "", "test-database");
$id = $_SESSION['id'];
$sql = "select * from account where uid ='$id'";
$r = $conn->query($sql);
$row = $r->fetch_assoc();
?>

<?php
if (isset($_POST['fname'])) {
    $fname = $_POST['fname'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $sql = "SELECT * FROM login WHERE username = '$fname'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        header("location:test-account.php?id=" . $row['id']);
    } else {
        header("Location: test-display.php");
    }

    $conn->close();
}

if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("location:test-login.php");
}

?>

<html>

<head>
    <link rel="stylesheet" href="css\header.css">
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>
    <div id="title-bar">
        <div id="logo">
            <a href="test-display.php?page-nr=1">
                <img src="imgs/verse-small.png" alt="no image found" id="main-logo">
            </a>
        </div>

        <div class="profile-picture">
            <a href="test-account.php?id=<?php echo $row['uid']; ?>">
                <img src="<?php echo htmlspecialchars($row['ppic']); ?>" alt="Profile Picture">
            </a>
        </div>

        <div id="searchbox">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="text" name="fname" placeholder="Find Bloggers">
            </form>
        </div>


        <div id="clown">

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div id="logout-text">
                    <input type="submit" name="logout" value="Logout"></input>
                </div>
            </form>

            <!--
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div id="logoutbtn">
                    <button type="submit" name="logout" value="Logout">
                        <box-icon type='solid' name='log-out'>
                    </button>
                </div>
            </form>
            -->

        </div>

    </div>

    <div id="uheader">
        <a href="test-account.php?id=<?php echo $row['uid']; ?>">
            <?php echo ($_SESSION['username']); ?>
        </a>
    </div>

    <div id="posting">
        <a href="test-posting.php">Write a Blog</a>
    </div>

    <div id="msging">
        <a href="test-messaging.php">Messages </a>
    </div>
    </div>

</body>
<script src="jquery-3.7.1.min.js"></script>

<script>
    document.getElementById("fname").addEventListener("keypress", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.querySelector("form").submit();
        }
    });
</script>

</html>