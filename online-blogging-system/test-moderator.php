<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
echo("BAD Posts");
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sid = $_SESSION['id'];
        $currentTimestamp = time();
        $sql = "select p.*,a.username from posts p join account a on p.poster=a.uid where p.status='normal' order by reports desc;";
        $mo = $conn->query($sql);
        if ($mo->num_rows > 0) {
            while ($row = $mo->fetch_assoc()) {
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                echo "<div id='username'>";
                echo $row['username'] . "<br>";
                echo "</div>";
                echo "</td>";

                echo "<td>";
                echo "<div id='time'>";
                echo $formattedTime . " ago<br>";
                echo "</div>";
                echo "</td>";

                echo "</tr>";
                echo "</table>";
                
                echo "<div id='title'>";
                echo "<a href='test-display-post.php?id=" . $row['id'] . "'>" . $row['Title'] . "</a>" . "<br>";
                echo "</div>";

                echo "<div id='display-text'>";
                echo $row['display-text'];
                echo "</div>";

                echo "<table>";
                echo "<tr>";
                
                echo"<td>";
                echo "<div id='like-btn'>";
                echo "<img src='imgs/like.png'>";
                echo "</div>";
                echo "</td>";

                echo "<td>";
                echo "<div id='likes'>";
                echo $row['likes'] . "<br>";
                echo "</div>";
                echo "</td>";


                echo "</tr>";
                echo "</table>";
                echo"</div>";

                echo "<div id='image'>";
                echo "<img src='" . $row['image'] . "'";
                echo "</div>";

                echo "</div>";
                echo "</div>";
                echo "<br>";
                echo "<br>";
            }
        }

?>
<?php
echo("BAD People");
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sid = $_SESSION['id'];
        $currentTimestamp = time();
        $sql = "select p.*,a.username from posts p join account a on p.poster=a.uid where p.status='normal' order by reports desc;";
        $mo = $conn->query($sql);
        if ($mo->num_rows > 0) {
            while ($row = $mo->fetch_assoc()) {
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                echo "<div id='username'>";
                echo $row['username'] . "<br>";
                echo "</div>";
                echo "</td>";

                echo "<td>";
                echo "<div id='time'>";
                echo $formattedTime . " ago<br>";
                echo "</div>";
                echo "</td>";

                echo "</tr>";
                echo "</table>";
                
                echo "<div id='title'>";
                echo "<a href='test-display-post.php?id=" . $row['id'] . "'>" . $row['Title'] . "</a>" . "<br>";
                echo "</div>";

                echo "<div id='display-text'>";
                echo $row['display-text'];
                echo "</div>";

                echo "<table>";
                echo "<tr>";
                
                echo"<td>";
                echo "<div id='like-btn'>";
                echo "<img src='imgs/like.png'>";
                echo "</div>";
                echo "</td>";

                echo "<td>";
                echo "<div id='likes'>";
                echo $row['likes'] . "<br>";
                echo "</div>";
                echo "</td>";


                echo "</tr>";
                echo "</table>";
                echo"</div>";

                echo "<div id='image'>";
                echo "<img src='" . $row['image'] . "'";
                echo "</div>";

                echo "</div>";
                echo "</div>";
                echo "<br>";
                echo "<br>";
            }
        }

?>

</body>
</html>