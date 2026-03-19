<?php
require 'db_connect.php';

$sql = "ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user'";

if ($conn->query($sql) === TRUE) {
    echo "Column 'role' added successfully.<br>";
} else {
    echo "Error adding column: " . $conn->error . "<br>";
}

// Optionally set the first user as admin for testing
$sql_update = "UPDATE users SET role = 'admin' LIMIT 1";
if ($conn->query($sql_update) === TRUE) {
    echo "First user set as admin successfully.<br>";
}

$conn->close();
?>
