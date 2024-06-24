<?php
include 'test-header.php';
//session_start();
$sid = $_SESSION['id'];
$mysqli = new mysqli('localhost:3307', 'root', '', 'test-database');
if ($mysqli->error) {
    echo ("No connection :(");
}
$records = $mysqli->query($_SESSION['query']);
$nr_of_rows = $records->num_rows;
$rows_per_page = 5;
$pages = ceil($nr_of_rows / $rows_per_page);
$start = 0;
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}
$result = $mysqli->query($_SESSION['query'] . " LIMIT $start, $rows_per_page");
?>

<?php
if (isset($_POST['view'])) {
    $selectedoption = $_POST['choice'];
    if ($selectedoption == "allh") {
        $_SESSION['query'] = "select p.*,a.username from posts p join account a on p.poster = a.uid where p.poster != '$sid' and p.status != 'hide'";
        header("Location:test-display.php?page-nr=1");
    } elseif ($selectedoption == "friends") {
        $_SESSION['query'] = "SELECT p.*, a.username FROM posts p JOIN account a ON p.poster = a.uid JOIN follower f ON f.receiver = p.poster AND f.sender = '$sid' WHERE p.status != 'hide' ORDER BY date desc";
        header("Location:test-display.php?page-nr=1");
    } elseif ($selectedoption == "reports"&& ($_SESSION['role'] == "mod"|| $_SESSION['role'] == "smod")) {
        $_SESSION['query'] = "SELECT p.*, a.username FROM posts p JOIN account a ON p.poster = a.uid where p.reports>0 ORDER BY reports desc  ";
        header("Location:test-display.php?page-nr=1");
    } elseif ($selectedoption == "locked" && ($_SESSION['role'] == "mod"|| $_SESSION['role'] == "smod")) {
        $_SESSION['query'] = "SELECT p.*, a.username FROM posts p JOIN account a ON p.poster = a.uid where p.status='lock'  ";
        header("Location:test-display.php?page-nr=1");
    }elseif ($selectedoption == "hidden" && ($_SESSION['role'] == "mod"|| $_SESSION['role'] == "smod")) {
        $_SESSION['query'] = "SELECT p.*, a.username FROM posts p JOIN account a ON p.poster = a.uid where p.status='hide'  ";
        header("Location:test-display.php?page-nr=1");
    } elseif ($selectedoption == "striked" && ($_SESSION['role'] == "mod"|| $_SESSION['role'] == "smod")) {
        $_SESSION['query'] = "SELECT p.*, a.username FROM posts p JOIN account a ON p.poster = a.uid where a.strike>0 and p.reports>0 ORDER BY reports desc ";
        header("Location:test-display.php?page-nr=1");
    } else {
        echo ("i am not working");
    }
}
?>

<?php
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Verse:A modern blogging platform</title>
    <link rel="stylesheet" href="css/display.css">
</head>

<body>
    <div id="viewselect">
        <div id="leblogs">Blogs</div>
        <form id="viewForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <select id="choice" name="choice" onchange="submitForm()">
                <option value="">Choose view</option>
                <option id="oval" value="allh">View Recent Posts</option>
                <option id="oval" value="friends">View Followed Posts</option>
                <?php if ($_SESSION['role'] == "mod" || $_SESSION['role'] == "smod"): ?>
                    <option value="reports">View Reported Posts</option>
                    <option value="locked">View Locked Posts</option>
                    <option value="hidden">View Hidden Posts</option>
                    <option value="striked">View Striked Posts</option>
                <?php endif; ?>
            </select>
            <input type="hidden" name="view" value="1">
        </form>
    </div>
    <div class="content">

        <?php

        $currentTimestamp = time();
        $rowExists = false;
        while ($row = $result->fetch_assoc()) {
            $rowExists = true;
            $postTimestamp = strtotime($row['date']);
            $timeDifference = $currentTimestamp - $postTimestamp;
            $formattedTime = formatTime($timeDifference);
            echo "<div id='display-container'>";
            echo "<div id='one-post'>";
            echo "<div id='text-content'>";
            echo "<div id='username'>";
            echo "<a href='test-account.php?id={$row['poster']}'>";
            echo $row['username'] . "<br>";
            echo "</a>";
            echo "</div>";
            echo "<div id='time'>";
            echo $formattedTime . " ago<br>";
            echo "</div>";
            echo "<div id='title'>";
            echo "<a href='test-display-post.php?id=" . $row['id'] . "&scrollPosition=0&page-nr=1'>" . $row['Title'] . "</a><br>";
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
            echo "<div id='blogimage'>";
            echo "<img src='" . $row['image'] . "'";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        if (!$rowExists) {
            echo "No Blogs Found :(";
        }
        ?>
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
    <div class="pagination"> </div>

    <a class="bottombuttons" href="?page-nr=1">First</a>

    <?php
    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
        ?> <a class="bottombuttons" href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a> <?php
    } else {
        ?> <a class="bottombuttons">Previous</a> <?php
    }
    ?>
    <div class="page-numbers">
        <?php
        if (!isset($_GET['page-nr'])) {
            ?> <a class="activebottombuttons" href="?page-nr=1">1</a> <?php
             $count_from = 2;
        } else {
            $count_from = 1;
        }
        ?>

        <?php
        for ($num = $count_from; $num <= $pages; $num++) {
            if ($num == @$_GET['page-nr']) {
                ?> <a class="activebottombuttons" href="?page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            } else {
                ?> <a class="bottombuttons" href="?page-nr=<?php echo $num ?>"><?php echo $num ?></a> <?php
            }
        }
        ?>
    </div>
    <?php
    if (!isset($_GET['page-nr'])) {
        ?> <a class="activebottombuttons" href="?page-nr=1">1</a> <?php
         $count_from = 2;
    } else {
        $count_from = 1;
    }
    ?>

    <?php
    if (isset($_GET['page-nr'])) {
        if ($_GET['page-nr'] >= $pages) {
            ?> <a class="bottombuttons">Next</a> <?php
        } else {
            ?> <a class="bottombuttons" href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a> <?php
        }
    } else {
        ?> <a class="bottombuttons" href="?page-nr=2">Next</a> <?php
    }
    ?>
    <a class="bottombuttons" href="?page-nr=<?php echo $pages ?>">Last</a>
</body>

<script>
    function submitForm() {
        document.getElementById("viewForm").submit();
    }
</script>

</html>