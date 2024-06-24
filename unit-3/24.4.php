<!-- d. Write a PHP program to delete a record from a table in MySQL -->

<?php

$conn = new mysqli("localhost:3307", "root", "", "js");

$sql = "DELETE FROM user WHERE id='1'";
$res = mysqli_query($conn, $sql);
if ($res) {
    echo "deleted succesfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>