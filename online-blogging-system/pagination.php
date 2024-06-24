<?php
$id = $_GET['id'];
echo($id);
$sid = $_SESSION['id'];
echo($sid);
$pid=70;
$mysqli = new mysqli('localhost:3307', 'root', '', 'test-database');
if ($mysqli->error) {
    echo ("No connection :(");
}
$records = $mysqli->query("SELECT * FROM comment");
$nr_of_rows = $records->num_rows;
$rows_per_page = 2;
$pages = ceil($nr_of_rows / $rows_per_page);
$start = 0;
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}
$r3 = $mysqli->query("SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE pid = '$pid' LIMIT $start, $rows_per_page");
?>
<?php

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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>php and mysql pagination</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="testing/three.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 20px;
        }

        body {
            font-family: sans-serif;
            min-height: 100vh;
            color: #555;
            padding: 30px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #006cb3;
            padding: 10px 20px;
            border: thin solid #d4d4d4;
            transition: all 0.3s;
            font-size: 18px;
        }

        a.active {
            background-color: #0d81cd;
            color: #fff;
        }

        .page-info {
            margin-top: 90px;
            font-size: 18px;
            font-weight: bold;
        }

        .pagination {
            margin-top: 20px;
        }

        .content p {
            margin-bottom: 15px;
        }

        .page-numbers {
            display: inline-block;
        }
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
    <div class="content">
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
    </div>
    <div class="page-info">
        <?php
        if (!isset($_GET['page-nr'])) {
            $page = 1;
        } else {
            $page = $_GET['page-nr'];
        }
        ?>
        Showing <?php echo $page ?> of <?php echo $pages; ?> pages
    </div>
    <div class="pagination">

    </div>
    <a href="?page-nr=1">First</a>
    <?php
    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
        ?> <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a> <?php
    } else {
        ?> <a>Previous</a> <?php
    }
    ?>
    <div class="page-numbers">
        <?php
        if (!isset($_GET['page-nr'])) {
            ?> <a class="active" href="?page-nr=1">1</a> <?php
             $count_from = 2;
        } else {
            $count_from = 1;
        }
        ?>

        <?php
        for ($num = $count_from; $num <= $pages; $num++) {
            if ($num == @$_GET['page-nr']) {
                ?> <a class="active" href="?page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            } else {
                ?> <a href="?page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            }
        }
        ?>
    </div>
    <?php
    if (!isset($_GET['page-nr'])) {
        ?> <a class="active" href="?page-nr=1">1</a> <?php
         $count_from = 2;
    } else {
        $count_from = 1;
    }
    ?>


    <?php
    if (isset($_GET['page-nr'])) {
        if ($_GET['page-nr'] >= $pages) {
            ?> <a>Next</a> <?php
        } else {
            ?> <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a> <?php
        }
    } else {
        ?> <a href="?page-nr=2">Next</a> <?php
    }
    ?>
    <a href="?page-nr=<?php echo $pages ?>">Last</a>
</body>

</html>