<?php
$id = $_GET['id'];
echo($id);
//for posting comment
if (isset($_POST["cmt"])) {
    //  $status = $_POST['status'];
    if ($status != "lock") {
        $id = $_POST['id'];
        $uid = $_SESSION['id'];
        $cmt = $_POST['comment'];
        $url = "test-display-post.php?id=" . $id;
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "insert into  comment values(0,'$id','$uid',0,'$cmt',DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
        $r = $conn->query($sql);
        $sql = "update posts set comment=comment+1 where id='$id'";
        $r = $conn->query($sql);
        if ($r) {
            echo ("comment added succesfully");
        }
    } else {
        echo ("The Post is Locked");
        // header("Location: $url");
    }
}

if (isset($_POST["deletecmt"])) {
    $id = $_POST['id'];
    $url = "test-display-post.php?id=" . $id;
    $cid = ($_POST['cid']);
    // $cid = $cid+=1;
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if ($conn->error) {
        echo ('error');
    }
    $sql = "DELETE FROM comment WHERE id='$cid'";
    $r = $conn->query($sql);
    $sql = "update posts set comment=comment-1 where id='$id'";
    $r = $conn->query($sql);
    echo 'comment deleted successfully.';
    header("Location: $url");
} else {
    //header("location:test-login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Comment System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="testing/three.js"></script>
    <style>
        .comment {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .comment-text {
            flex-grow: 1;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php
    $img = $_SESSION['ppic'];
    ?>
    <div id="commentingbox">
        <div id="commenterppic">
            <img src="<?php echo $img; ?>" alt="Image not found">
        </div>

        <form id="all-form" method="POST">
            <?php echo '<input  type="hidden" name="id" value="' . $id . '">' ?>
            <div id="textboxdiv">
                <textarea name="comment" id="maintextbox" rows="6" cols="50"
                    placeholder="Enter your comment here"></textarea>
            </div>

            <input type="submit" name="cmt" id="commentbtn">
            <!-- <td><input type="submit" name="detailed" value="see all comments"></td>-->
        </form>
    </div>

    <h1>Comment System</h1>
    <?php
    // Connect to the database
    $conn = new mysqli("localhost:3307", "root", "", "test-database");

    // Retrieve comments
    $postid = 1; // Replace with the actual post ID
    $sql = "SELECT * FROM comment WHERE pid = '70' and response='0' ORDER BY date ASC";
    $result = $conn->query($sql);

    // Display comments
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '<div class="comment-text">' . $row['comment'] . '</div>';
            echo '<button class="reply-btn" data-commentid="' . $row['id'] . '">Reply</button>';
            echo '</div>';

            echo '<button class="edit-btn" data-commentid="' . $row['id'] . '">Edit</button>';
            echo '<div class="edit-form" data-commentid="' . $row['id'] . '" style="display: none;">';
            echo '<input type="text" class="edit-input" value="' . htmlspecialchars($row['comment']) . '">';
            echo '<button class="submit-edit">Submit</button>';
            echo '</div>';

            $conn3 = new mysqli("localhost:3307", "root", "", "test-database");
            $sql3 = "SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE pid = '$id'";
            $r3 = $conn3->query($sql3);
            $row3 = $r3->fetch_assoc();
          //  if ($_SESSION['id'] == $row3['pid'] or $_SESSION['id'] == $row3['uid'] or $role == "mod") {
                $url = "testing/one.php";
                echo ("<div class='deletebtn'>");

                echo '<form method="post" action="' . $url . '">';
                echo '<input  type="hidden" name="id" value="' . $id . '">';
                echo '    <input type="hidden" name="deletecmt" value="true">';
                echo '    <input  type="hidden" name="cid" value="' . $row3['cid'] . '">';
                echo '    <input type="submit" name="deletecmt" value="delete"> </input>';
                echo '</form>';

                echo ("</div>");
          //  }

            displayReplies($conn, $row['id']);
        }
    } else {
        echo "No comments found.";
    }

    // Close the database connection
    $conn->close();

    // Function to display replies
    function displayReplies($conn, $parentid)
    {
        $sql = "SELECT * FROM comment WHERE response = $parentid ORDER BY date ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="replies">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="comment" style="margin-left: 20px;">';
                echo '<div class="comment-text">' . $row['comment'] . '</div>';
                echo '<button class="reply-btn" data-commentid="' . $row['id'] . '">Reply</button>';
                echo '</div>';
                displayReplies($conn, $row['id']);
            }
            echo '</div>';
        }
    }
    ?>

    <div id="reply-form" style="display: none;">
        <input type="text" id="reply-input" placeholder="Enter your reply">
        <button id="submit-reply">Submit</button>
    </div>



</body>

</html>