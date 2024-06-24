<?php
session_start();
    echo("i m work");
    $status = $_POST['status'];
    if ($status != "lock") {
        $id = $_POST['id'];
        $uid = $_SESSION['id'];

$scrollPosition = $_POST['scrollPosition'] ?? 0;
$url = 'test-display-post.php?id=' . $id . '#scrollPosition=' . $scrollPosition;
   
        $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
        if ($conn->error) {
            echo ('error');
        }
        $sql = "select * from likes where pid='$id' and uid='$uid'";
        $r = $conn->query($sql);
        if ($r->num_rows > 0) {
            $sql = "DELETE FROM likes WHERE pid = '$id' AND uid = '$uid'";
            $conn->query($sql);
            $sql = "UPDATE posts SET likes = likes - 1 WHERE id = '$id'";
            $conn->query($sql);
            //header("Location: $url");
            http_response_code(200);
            
        } else {
            $sql = "INSERT INTO `likes` VALUES (0, '$id', '$uid', DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
            $conn->query($sql);
            $sql = "UPDATE posts SET likes = likes + 1 WHERE id = '$id'";
            $conn->query($sql);
           // header("Location:$url");
            http_response_code(200);
            
        }
    } else {
        echo "post is locked";
    }

