<?php
$conn = new mysqli("localhost:3307", "root", "", "test-database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$commentid = $_POST['commentid'];
$reply = $_POST['reply'];
$postid = $_POST['postid'];
$userid = $_POST['userid'];

$response = ($commentid == 0) ? 0 : $commentid;
$sql = "INSERT INTO comment VALUES (0, $postid, $userid, $response, '$reply', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "Reply submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>