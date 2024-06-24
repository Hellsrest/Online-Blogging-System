<?php
$conn = new mysqli("localhost:3307", "root", "", "test-database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$commentid = $_POST['commentid'];
$editedComment = $_POST['comment'];
echo($commentid);
echo($editedComment);
$sql = "update comment set comment = '$editedComment' where id = $commentid";
if ($conn->query($sql) === TRUE) {
    echo "Comment updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>