<!-- b. Write a PHP program to read all data from a table in MySQL -->

<?php

$conn = new mysqli("localhost:3307", "root", "", "js");
$sql = "SELECT * FROM user";
$res = mysqli_query($conn, $sql);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $name = $row['name'];
        $email = $row['email'];
        $age = $row['age'];
        echo "Name: $name, Email: $email, Age: $age <br>";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>