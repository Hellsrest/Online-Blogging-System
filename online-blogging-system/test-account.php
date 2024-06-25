<!DOCTYPE html>
<html lang="en">

<?php
include 'test-header.php';
//session_start();
?>

<head>
    <link rel="stylesheet" href="css\account.css">
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <title>Document</title>
</head>
<?php
date_default_timezone_set('UTC');

echo $_SESSION['id'];
$role = $_SESSION['role'];
if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $sql = "select * from account where uid ='$id'";
    $sql1 = "select * from follower where sender='$id'";
    $sql2 = "select * from follower where receiver='$id'";
    $sql3 = "select * from posts where poster='$id'";

    $r = $conn->query($sql);
    $r1 = $conn->query($sql1);
    $r2 = $conn->query($sql2);
    $r3 = $conn->query($sql3);

    $row = $r->fetch_assoc();
    $row1 = $r1->fetch_assoc();
    $row2 = $r2->fetch_assoc();
    $row3 = $r3->fetch_assoc();

    $uid = ($row['uid']);
    $username = ($row['username']);
    $email = ($row['email']);
    $password = ($row['password']);
    $bio = ($row['bio']);
    $strike = ($row['strike']);
    $imageurl = $row["ppic"];
    $role = ($row['role']);
    if ($row1) {
        $following = $r1->num_rows;
    } else {
        $following = 0;
    }

    if ($row2) {
        $followed = $r2->num_rows;
    } else {
        $followed = 0;
    }

    if ($row3) {
        $allposts = $r3->num_rows;
    } else {
        $allposts = 0;
    }
}

if (isset($_POST['deletepost'])) {
    $id = $_POST['id'];
    echo ($id);
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    $sql = "DELETE FROM posts WHERE id = '$id'";
    $r = $conn->query($sql);
    echo 'Post deleted successfully.';
    header("Location: test-display.php");
    $conn->close();
}


if (isset($_POST['promote'])) {
    $id = $_POST['id'];
    $crole=$_POST['currentrole'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if($crole=="user"){
        $sql = "update account set role='mod'  WHERE uid = '$id'";
        $r = $conn->query($sql);
        if($r){
            echo 'Promoted  successfully.';
        }else{
            echo 'error';
        }
    }else if($crole=="mod"){
        $sql = "update account set role='smod'  WHERE uid = '$id'";
        $r = $conn->query($sql);
        if($r){
            echo 'Promoted  successfully.';
        }else{
            echo 'error';
        }
    }else{
        echo "cannot promote further";
    }
   
}

if (isset($_POST['demote'])) {
    $id = $_POST['id'];
    $crole=$_POST['currentrole'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if($crole=="mod"){
        $sql = "update account set role='user'  WHERE uid = '$id'";
        $r = $conn->query($sql);
        if($r){
            echo 'Demoted  successfully.';
        }else{
            echo 'error';
        }
    }else if($crole=="smod" && $id!=79){
        $sql = "update account set role='mod'  WHERE uid = '$id'";
        $r = $conn->query($sql);
        if($r){
            echo 'Demoted  successfully.';
        }else{
            echo 'error';
        }
    }else{
        echo "cannot Demote further";
    }
}

if (isset($_POST['strike'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    $sql = "update account set strike = strike + 1 where uid = '$id';";
    $r = $conn->query($sql);
    echo 'User Striked Succesfully';
    header("Location: test-display.php");
}

if (isset($_POST['unstrike'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    $sql = "update account set strike = strike - 2 where uid = '$id';";
    $r = $conn->query($sql);
    echo 'User unStriked Succesfully';
    header("Location: test-display.php");
}

if (isset($_POST['report'])) {
    $id = $_GET['id'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    $sql = "insert into posts reports reports=reports+1 where id='$id'";
    $r = $conn->query($sql);
    echo 'post reported succesfully';
    header("Location: test-display.php");
    $conn->close();
}

if (isset($_POST['follow'])) {
    $id = $_SESSION['id'];
    $rid = $_POST['id'];
    $uid = $_POST['id'];
    $url = "test-account.php?id=" . $uid;
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if ($conn->error) {
        echo ('error');
    }
    $sql = "select * from follower where sender='$id' and receiver='$rid'";
    $r = $conn->query($sql);
    if ($r->num_rows > 0) {
        $sql = "DELETE FROM follower WHERE sender='$id' and receiver='$rid'";
        $conn->query($sql);
        header("Location: $url");
    } else {
        $sql = "INSERT INTO `follower` VALUES (0, '$id', '$rid', DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
        $conn->query($sql);
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

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div>
            <?php echo '<input type="hidden" name="id" value="' . $id . '">'; ?>
        </div>

        <div id="headdiv">
            <div class="mainimage">
                <?php echo '<img src="' . $imageurl . '" alt="Image">'; ?>
            </div>

            <div id="mainuser">
                <?php echo $username; ?>
            </div>

            <div id="ffp">
                <div class="ffpitem">
                    <?php echo "<div style='font-weight: 600;'>$allposts</div>"; ?> posts
                </div>

                <div id="ffpitem">
                    <?php echo "<div style='font-weight: 600;'>$followed</div>"; ?><a href="test-follow.php?id=<?php echo $id; ?>&f=0">follower</a>
                    
                </div>

                <div id="ffpitem">
                    <?php echo "<div style='font-weight: 600;'>$following</div>"; ?> <a href="test-follow.php?id=<?php echo $id; ?>&f=1">following</a>
                </div>
            </div>

            <?php
 
            if($id!=$_SESSION['id']){
                echo "<div id='followbutton'>";
                echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">";
                echo "    <input type=\"hidden\" name=\"follow\" value=\"true\">";
                echo "    <input type=\"hidden\" name=\"id\" value=\"" . $id . "\">";
                echo "    <input type=\"submit\" value=\"follow\">";
                echo "</form>";
                echo "</div>";
            }
            ?>



            <div id="mainbio">
                <?php echo $bio; ?>
            </div>

            <div id="mainemail">
                <?php echo $email; ?>
            </div>


            <?php
            if ($_SESSION['id'] == $uid) {
                echo ('<div id="editbutton">');
                echo "<button>";
                echo "<a href='test-account-edit.php?id=" . $uid . "'> Edit Profile</a>";
                echo "</button>";
                echo ('</div>');
            }

            if ($_SESSION['role'] == "smod") {
                $url = "test-account.php?id=" . $row['uid'];
                if ($_SESSION['role'] == "smod") {
                    if($role!="smod"){
                        echo '<form method="post" action="'.$url.'">';  
                        echo '    <input type="hidden" name="id" value="' . $id . '">';
                        echo '    <input type="hidden" name="currentrole" value="' . $role . '">';
                        echo '    <input type="submit" name="promote" id="promotebtn" value="Promote">';
                        echo '</form>';
                    }
                    if($role!="user"){
                    echo '<form method="post" action="'.$url.'">';  
                    echo '    <input type="hidden" name="id" value="' . $id . '">';
                    echo '    <input type="hidden" name="currentrole" value="' . $role . '">';
                    echo '    <input type="submit" name="demote" id="demote" value="Demote">';
                    echo '</form>';
                    }
                }
            }

            ?>


        </div>


        <?php
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "select * from account where uid='$id'";
        $r = $conn->query($sql);
        $row = $r->fetch_assoc();
        $strike = $row['strike'];

        echo ("<div id='modoption'>");

        if ($role == "mod" || $role=="smod") {

            echo ("<div class='moderatoroption'>");
            echo ($row['strike'] . " Strikes");
            echo ("</div>");
            
            if ($row['role'] != 'mod' && $row['role'] != 'smod') {
            echo ("<div class='moderatoroption'>");
            $url = "test-account.php?id=" . $row['uid'];
            echo '<form method="post" action="' . $url . '">';
            echo '    <input type="hidden" name="strike" value="true">';
            echo '    <input type="hidden" name="id" value=' . $id . ' >';
            echo '    <input type="submit" name="strike" value="strike"> </input>';

            echo '</form>';

            if($row['strike']>0){
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="strike" value="true">';
                echo '    <input type="hidden" name="id" value=' . $id . ' >';
                echo '    <input type="submit" name="unstrike" value="unstrike"> </input>';
                echo '</form>';
            }
            
            echo ("</div>");

            echo ("<div class='moderatoroption'>");
            if ($strike >= 3) {
                $url = "test-account.php?id=" . $id;
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="finalsolution" value="true">';
                echo '    <input type="hidden" name="id" value=' . $id . ' >';
                echo '    <input type="submit" name="finalsolution" value="delete account"> </input>';
                echo '</form>';
            }
            echo ("</div>");
        }
    }
        echo ("</div>");
        ?>


    </form>

    <?php
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if ($conn->error) {
        echo ('error');
    }
    $pid = $_SESSION['id'];
    $currentTimestamp = time();
    $sql = "SELECT * FROM posts where poster='$uid'";
    $ma = $conn->query($sql);
    if ($ma->num_rows > 0) {
        while ($row = $ma->fetch_assoc()) {
            $postTimestamp = strtotime($row['date']);
            $timeDifference = $currentTimestamp - $postTimestamp;
            $formattedTime = formatTime($timeDifference);

            echo "<div id='display-container'>";

            echo "<div id='one-post'>";
            echo "<div id='text-content'>";

            echo "<div id='username'>";
            echo "<a href='test-account.php?id={$row['poster']}'>";
            echo $username . "<br>";
            echo "</a>";
            echo "</div>";

            echo "<div id='time'>";
            echo $formattedTime . " ago<br>";
            echo "</div>";

            echo "<div id='title'>";
            echo "<a href='test-display-post.php?id=" . $row['id'] . "'>" . $row['Title'] . "</a>" . "<br>";
            echo "</div>";

            echo "<div id='display-text'>";
            echo $row['display-text'];
            echo "</div>";

            echo "<div id='like'>";
            echo "<div id='like-btn'>";
            echo "<box-icon name='like'></box-icon>";
            echo "</div>";
            echo "<div id='like-number'>";
            echo $row['likes'] . "<br>";
            echo "</div>";
            echo "</div>";

            echo "<div id='comment'>";
            echo "<div id='comment-btn'>";
            echo "<box-icon name='comment'></box-icon>";
            echo "</div>";
            echo "<div id='comment-number'>";
            echo $row['comment'] . "<br>";
            echo "</div>";
            echo "</div>";

            echo "<div id='image'>";
            echo "<img src='" . $row['image'] . "'";
            echo "</div>";

            echo "</div>";
            echo "</div>";

            echo "</div>";

            echo "<div id='report-btn'>";
            $url = "test-display-post.php?id=" . $row['id'];
            echo '<form method="post" action="' . $url . '">';
            echo '    <input type="hidden" name="report" value="true">';
            echo '    <input type="hidden" name="id" value="' . $row['id'] . '">'; // Add a hidden input for the post ID
            echo '    <input type="submit" name="report" value="report"> </input>';
            echo '</form>';
            echo "</div>";

            if ($_SESSION['id'] == $row['poster']) {
                echo "<div id='edit'>";
                echo "<a href='test-editing.php?id=" . $row['id'] . "' style='margin-left:1%;'> Edit </a>";
                echo "</div>";

            }

            if ($_SESSION['id'] == $row['poster'] or $role == "mod") {
                echo "<div id='delete-btn'>";
                $url = "test-display-post.php?id=" . $row['id'];
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="deletepost" value="true">';
                echo '    <input type="hidden" name="id" value="' . $row['id'] . '">'; // Add a hidden input for the post ID
                echo '    <input type="submit" name="deletepost" value="delete"> </input>';
                echo '</form>';
                echo "</div>";
            }

            echo "</div>";
            if ($_SESSION['id'] == $row['poster'] or $role == "mod") {
                echo "<div id='reports'>";
                echo "Reports" . "<br>";
                echo $row['reports'];
                echo "</div>";
            }
            echo "</div>";

            echo "<br>";
            echo "<br>";
        }


    }

    function formatTime($timeDifference)
    {
        $timePeriods = array(
            31536000 => 'year',
            2592000 => 'month',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        foreach ($timePeriods as $seconds => $period) {
            $numberOfPeriods = floor($timeDifference / $seconds);
            if ($numberOfPeriods > 0) {
                return $numberOfPeriods . ' ' . $period . ($numberOfPeriods > 1 ? 's' : '');
            }
        }
        return 'just now';
    }
    ?>

</body>

</html>