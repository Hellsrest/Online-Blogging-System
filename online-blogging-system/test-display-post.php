<?php
include 'test-header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <link rel="stylesheet" href="css\display-post.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<?php
//session_start();
date_default_timezone_set('UTC');
$locka = "
<script>
    alert('This post is locked');
</script>
";
$role = $_SESSION['role'];

if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $sql = "select p.*, a.*,p.date as postdate,p.id as postid from posts as p join account as a on p.poster = a.uid where p.id = '$id';";
    $r = $conn->query($sql);
    $row = $r->fetch_assoc();
    $id = ($row['postid']);
    $title = ($row['Title']);
    $img = htmlspecialchars($row['image']);
    $display = ($row['display-text']);
    $actual = ($row['post']);
    $formatted_text = nl2br($actual);
    $likes = ($row['likes']);
    $status = ($row['status']);
    $postdate = $row['postdate'];
    $poster = $row['poster'];
    $reports = $row['reports'];
}

if (isset($_POST['report'])) {
    $status = $_POST['status'];
    if ($status != "lock") {
        $id = $_POST['id'];
        $uid = $_SESSION['id'];
        $url = "test-display-post.php?id=" . $id;
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "select * from reports where pid='$id' and uid='$uid'";
        $r = $conn->query($sql);
        if ($r->num_rows > 0) {
            $sql = "DELETE FROM reports WHERE pid = '$id' AND uid = '$uid'";
            $conn->query($sql);
            $sql = "UPDATE posts SET reports = reports - 1 WHERE id = '$id'";
            $conn->query($sql);
            header("Location: $url");
        } else {
            $sql = "INSERT INTO `reports` VALUES (0, '$id', '$uid', DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
            $conn->query($sql);
            $sql = "UPDATE posts SET reports = reports + 1 WHERE id = '$id'";
            $conn->query($sql);
            header("Location: $url");
        }
    } else {
        header("Location: test-display.php");
    }
}

if (isset($_POST["setstatus"])) {
    $status = $_POST['status'];
    if ($status != "lock") {
        $id = $_POST['id'];
        $url = "test-display.php";
        $status = $_POST['newstatus'];
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "update posts set status = '$status' WHERE id = '$id'";
        $r = $conn->query($sql);
        header("Location: $url");
        exit;
    } else {
        echo ($locka);
        header("Location: test-display.php");

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

if (isset($_POST['unlock'])) {
    $id = $_POST['id'];
    echo ($id);

    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    $sql = "update posts set status='normal' WHERE id = '$id'";
    $r = $conn->query($sql);
    echo 'conversion successfully.';
    header("Location: test-display.php");
    $conn->close();

}

?>


<body>
    <div id="whole-text">
        <?php
        $id = $_GET['id'];
        $url = "test-display-post.php?id=" . $id . "";
        ?>
        <table>
            <form id="all-form" action="<?php echo $url ?>" method="POST">
                <tr>
                    <div>
                        <?php echo '<input  type="hidden" name="id" value="' . $id . '">' ?>
                        <?php echo '<input  type="hidden" name="status" value="' . $status . '">' ?>
                        <?php echo '<input  type="hidden" name="poster" value="' . $poster . '">' ?>
                        <?php echo '<input  type="hidden" name="poster" value="' . $_SESSION['role'] . '">' ?>
                    </div>
                    <div>
                        <?php echo '<input type="hidden" name="role" value="' . $role . '">'; ?>
                    </div>
                </tr>
                <tr>
                    <div id="title">
                        <?php echo $title; ?>
                    </div>
                </tr>
                <tr>
                    <div id="image">
                        <img src="<?php echo $img; ?>" alt="Image not found">
                    </div>
                </tr>
                <tr>
                    <div id="display">
                        <?php echo $display; ?>
                    </div>
                </tr>
                <tr>
                    <div id="actual">
                        <p>
                            <?php echo $formatted_text; ?>
                        </p>
                    </div>
                </tr>
        </table>

        <div id="post-image">
            <a href="test-account.php?id=<?php echo $row['uid']; ?>">
                <img src="<?php echo ($row['ppic']); ?>" alt="Profile Picture">
            </a>
        </div>

        <div id="post-username">
            <a href="test-account.php?id=<?php echo $row['uid']; ?>">
                <?php echo ($row['username']); ?>
            </a>
        </div>

        <div id="post-date">
            <?php echo ($postdate); ?>
        </div>


        <button name="like" id="like"><box-icon name='like' id="likebtn"></box-icon></button>

        <div id="likes">
            <?php echo $likes; ?>
        </div>

        <div id="reportbtn">
            <?php
            $id = $_GET['id'];
            $uid = $_SESSION['id'];
            $sql = "select * from reports where pid='$id' and uid='$uid'";
            $r = $conn->query($sql);
            if ($r->num_rows > 0) {
                echo '<input type="submit" name="report" value="unreport">';
            } else {
                echo '<input type="submit" name="report" value="report">';
            }

            ?>
        </div>

        <?php
        $role = $_SESSION['role'];
        $url = "test-display-post.php?id=" . $id;
            if ($role == "mod" || $role=="smod"||$poster==$_SESSION['id']) {
                echo '<div id="rprtnm">';
                echo ("Reports");
                echo '</div>';
                echo '<div id="rprtval">';
                echo ($reports);
                echo '</div>';
            if ($status != "lock" && $status != "hide") {
                echo '<tr>';
                echo '    <td>';
                echo '        <form method="post" action="' . $url . '">';
                echo '            <select id="actionSelect" name="newstatus">';
                echo '                <option value="lock">Lock</option>';
                echo '                <option value="hide">Hide</option>';
                echo '            </select>';
                echo '            <input type="submit" id ="koolbtn" name="setstatus" value="Submit">';
                echo '        </form>';
                echo '    </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="deletepost" value="true">';
                echo '    <input type="hidden" name="id" value="' . $id . '">';
                echo '    <input type="submit" name="deletepost" id="deleetebtn" value="delete"> </input>';
                echo '</form>';
                echo '</td>';
            }
            if ($status == "lock") {
                echo '<td>';
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="unlock" value="true">';
                echo '    <input type="hidden" name="id" value="' . $id . '">';
                echo '    <input type="submit" name="unlock" value="unlock post"> </input>';
                echo '</form>';
                echo '</td>';
            }
            if ($status == "hide") {
                echo '<td>';
                echo '<form method="post" action="' . $url . '">';
                echo '    <input type="hidden" name="unlock" value="true">';
                echo '    <input type="hidden" name="id" value="' . $id . '">';
                echo '    <input type="submit" name="unlock" value="unhide post"> </input>';
                echo '</form>';
                echo '</td>';
            }
            echo '</tr>';
        } ?>
    </div>
    </div>
    </form>
</body>

<?php
include 'test-comment.php';
?>

<script>

    $("#like").on("click", function (e) {
        e.preventDefault();
        var id = $('input[name="id"]').val();
        var status = $('input[name="status"]').val();
        var scrollPosition = $(window).scrollTop();

        $.ajax({
            url: "like.php",
            type: "POST",
            data: { id: id, scrollPosition: scrollPosition, status: status },
            success: function (data) {
                console.log("Success: I am working");
                redirectWithScrollPosition(id, scrollPosition, status);
            },
            error: function (xhr, status, error) {
                window.alert("Something went wrong: " + error);
                console.error("Error:", error);
            }
        });
    });

    function redirectWithScrollPosition(id, scrollPosition) {
        var url = "test-display-post.php?id=" + id + "#scrollPosition=" + scrollPosition;
        window.location.href = url;
        location.reload();
    }

</script>



</html>