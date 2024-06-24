<?php

$id = $_GET['id'];
$sid = $_SESSION['id'];
$mysqli = new mysqli('localhost:3307', 'root', '', 'test-database');
if ($mysqli->error) {
    echo ("No connection :(");
}
$records = $mysqli->query("SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE pid = '$id'");
$nr_of_rows = $records->num_rows;
$rows_per_page = 5;
$pages = ceil($nr_of_rows / $rows_per_page);
$start = 0;
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}
$r3 = $mysqli->query("SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE pid = '$id' LIMIT $start, $rows_per_page");
?>
<?php

//for posting comment
if (isset($_POST["submit-reply"])) {
    if ($status != "lock") {
        $id = $_POST['id'];
        $uid = $_SESSION['id'];
        $cmt = $_POST['comment'];
        $url = "test-display-post.php?id=" . $id . "&scrollPosition=0&page-nr=1";
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "insert into  comment values(0,'$id','$uid','$','$cmt',DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
    }
}

if (isset($_POST["cmt"])) {
    //  $status = $_POST['status'];
    if ($status != "lock") {
        $id = $_POST['id'];
        $uid = $_SESSION['id'];
        $cmt = $_POST['comment'];
        $url = "test-display-post.php?id=" . $id . "&scrollPosition=0&page-nr=1";
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "insert into  comment values(0,'$id','$uid',0,'$cmt',DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
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
    $url = "test-display-post.php?id=" . $id . "&scrollPosition=0&page-nr=1";
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

} else {
    //header("location:test-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/comment.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="testing/three.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>
    <div class="content">
        <?php $img = $_SESSION['ppic']; ?>

        <div id="commentingbox">
            <div id="commenterppic">
                <img src="<?php echo $img; ?>" alt="Image not found">
            </div>

            <div id="cmtusername">
                <?php
                echo ($_SESSION['username']);
                ?>
            </div>

            <form id="all-form" method="POST">
                <?php echo '<input  type="hidden" name="id" value="' . $id . '">' ?>
                <div id="textboxdiv">
                    <textarea name="comment" id="maintextbox" rows="6" cols="90"
                        placeholder="Enter your comment here"></textarea>
                </div>

                <input type="submit" name="cmt" id="commentbtn">
            </form>
        </div>

        <?php
        $conn = new mysqli("localhost:3307", "root", "", "test-database");
        $id = $_GET['id'];
        $sql = "SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE pid = '$id' and response=0 LIMIT $start, $rows_per_page";
        $result = $conn->query($sql);


        if ($result->num_rows < 0) {
            echo ("error");
        }

        // Display comments
        
        while ($row = $result->fetch_assoc()) {

            echo '<div class="comment">';
            echo '<div class="onecomment">';

            echo '<img class="commenterrppic" src="' . $row['ppic'] . '">';

            echo '<div class="commenterrusername">' . $row['username'] . '</div>';
            echo '<div class="commenterrtext">' . $row['comment'] . '</div>';
            echo '  <button class="reply-btn" data-commentid="' . $row['cid'] . '" data-postid="' . $row['pid'] . '" data-userid="' . $row['uid'] . '"><box-icon name="reply" ></box-icon></button> ';


            echo '<button class="edit-btn" data-commentid="' . $row['cid'] . '"><box-icon name="edit-alt" class="edit-alt" type="solid" ></box-icon></button>';
            echo '<div class="edit-form" data-commentid="' . $row['cid'] . '" style="display: none;">';
            echo '<input type="text" class="edit-input" value="' . htmlspecialchars($row['comment']) . '">';
            echo '<button class="submit-edit">Submit</button>';
            echo '</div>';

            if ($_SESSION['id'] == $row['pid'] or $_SESSION['id'] == $row['uid'] or $role == "mod") {
                $url = "test-display-post.php?id=" . $id . "&scrollPosition=0&page-nr=1";
                echo ("<div class='deletebtn'>");
                echo '<form method="post" action="' . $url . '">';
                echo '<input  type="hidden" name="id" value="' . $id . '">';
                echo '    <input type="hidden" name="deletecmt" value="true">';
                echo '    <input  type="hidden" name="cid" value="' . $row['cid'] . '">';
                echo '    <button  class="deleeetecmt" name="deletecmt" value="delete"><box-icon type="solid" name="trash-alt"></box-icon> </button>';
                echo '</form>';

                echo ("</div>");
                displayReplies($conn, $row['cid']);
            }
            echo ("</div>");
            echo ("</div>");

            echo "</div>";
            echo "</div>";

        }

        $conn->close();


        function displayReplies($conn, $parentid, $displayedComments = [])
        {
            $sql = "SELECT c.*, a.*,c.id as cid FROM `comment` c JOIN account a ON c.uid = a.uid WHERE response = $parentid ORDER BY c.date ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div class="replies">';
                while ($row = $result->fetch_assoc()) {
                    if (!in_array($row['cid'], $displayedComments)) {
                        $displayedComments[] = $row['cid'];
                        echo '<div class="comment" style="margin-left: 20px;">';
                        echo '<div class="onecomment">';
                        echo '<div class="reply-comment-ppic"> <img src="' . $row['ppic'] . '"> </div>';
                        echo '<div class="reply-comment-uname">' . $row['username'] . '</div>';
                        echo '<div class="reply-comment-text">' . $row['comment'] . '</div>';
                        echo '<button class="edit-btn" data-commentid="' . $row['cid'] . '"><box-icon name="edit-alt" class="edit-alt" type="solid" ></box-icon></button>';
                        echo '<div class="edit-form" data-commentid="' . $row['cid'] . '" style="display: none;">';
                        echo '<input type="text" class="edit-input" value="' . htmlspecialchars($row['comment']) . '">';
                        echo '<button class="submit-edit">Submit</button>';
                        echo '</div>';
                        echo ("</div>");
                        //displayReplies($conn, $row['id'], $displayedComments);
        
                    }
                    echo '</div>';
                }

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

    <?php $id = $_GET['id']; ?>
    <a class="bottombuttons" href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=1">First</a>

    <?php
    $id = $_GET['id'];
    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
        $id = $_GET['id'];
        ?> <a class="bottombuttons"
            href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a> <?php
    } else {
        ?> <a class="bottombuttons">Previous</a> <?php
    }
    ?>

    <div class="page-numbers">
        <?php
        $id = $_GET['id'];
        if (!isset($_GET['page-nr'])) {
            ?> <a class="activebottombuttons"
                href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=1">1</a> <?php
                   $count_from = 2;
        } else {
            $count_from = 1;
        }
        ?>

        <?php
        $id = $_GET['id'];
        for ($num = $count_from; $num <= $pages; $num++) {
            if ($num == @$_GET['page-nr']) {
                ?> <a class="activebottombuttons"
                    href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            } else {
                ?> <a class="bottombuttons"
                    href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            }
        }
        ?>
    </div>

    <?php
    $id = $_GET['id'];
    if (!isset($_GET['page-nr'])) {
        ?> <a class="activebottombuttons"
            href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=1">1</a> <?php
               $count_from = 2;
    } else {
        $count_from = 1;
    }
    ?>

    <?php
    $id = $_GET['id'];
    if (isset($_GET['page-nr'])) {
        if ($_GET['page-nr'] >= $pages) {
            ?> <a class="bottombuttons">Next</a> <?php
        } else {
            ?> <a class="bottombuttons"
                href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr<?php echo $_GET['page-nr'] + 1 ?>">Next</a> <?php
        }
    } else {
        ?> <a class="bottombuttons"
            href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=2">Next</a> <?php
    }
    ?>

    <a class="bottombuttons"
        href="test-display-post.php?id=<?php echo $id; ?>&scrollPosition=0&page-nr=<?php echo $pages ?>">Last</a>
</body>

</html>