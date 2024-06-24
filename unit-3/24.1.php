<!-- 24. PHP and MySQL
a. Write a PHP program to insert some data into a table in MySQL -->

<?php

$conn = new mysqli("localhost:3307", "root", "", "js");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = " Bisham";
$email = "bishampandey100@gmail.com";
$age = 15;

$sql = "INSERT INTO user VALUES (0,'$name', '$email', $age)";

if ($conn->query($sql)) {
    echo "Data Inserted succesfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
