<!-- f. Write PHP program to fetch records from two tables in MySQL using subqueries. -->
<?php
$conn = new mysqli("localhost:3307", "root", "", "js");
$sql = "SELECT * FROM user WHERE id IN (SELECT id FROM user2)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. ", Name: " . $row["name"]. "<br>";
    }
} else {
    echo "No records found";
}


