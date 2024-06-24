<?php
date_default_timezone_set('UTC');
session_start();
header('Content-Type: application/json');
$conn = new mysqli("localhost:3307", "root", "", "test-database");

$uid = $_SESSION['id'];
$msgs = array();

$sql1 = "SELECT m.*,a.*,DATE_FORMAT(m.date, '%Y-%m-%d %H:%i:%s') AS formatted_date FROM messages m join account a on m.sid=a.uid WHERE sid='$uid' or rid='$uid' order by m.date asc";
$r1 = $conn->query($sql1);

while ($row1 = $r1->fetch_assoc()) {
    $msg = array(
        'id' => $row1['id'],
        'sid' => $row1['sid'],
        'rid' => $row1['rid'],
        'message' => $row1['messege'], 
        'date' => $row1['formatted_date'],
        'username'=>$row1['username'],
        'ppic'=>$row1['ppic']
    );

    // Add the current post to the $posts array
    $msgs[] = $msg;
}

echo json_encode($msgs);
?>
