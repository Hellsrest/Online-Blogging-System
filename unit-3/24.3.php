<!-- c. Write a PHP program to update a record of a table in MySQL -->
<?php

$conn = new mysqli("localhost:3307", "root", "", "js");
$name = "Pandey";
$age = 200;

$sql = "UPDATE user SET name = '$name', age = $age WHERE id = '1'";
$res = mysqli_query($conn, $sql);
if ($res) {
    echo "Updated succesfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>