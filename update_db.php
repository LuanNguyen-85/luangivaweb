<?php
require 'db_connect.php';

// Add role column if it doesn't exist
$sql = "ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'user'";

if ($conn->query($sql) === TRUE) {
    echo "Column 'role' checked/created successfully.<br>";
} else {
    echo "Error adding role column: " . $conn->error . "<br>";
}

// Add phone column if it doesn't exist
$sql_phone = "ALTER TABLE users ADD COLUMN IF NOT EXISTS phone VARCHAR(20) NULL";
if ($conn->query($sql_phone) === TRUE) {
    echo "Column 'phone' checked/created successfully.<br>";
} else {
    echo "Error adding phone column: " . $conn->error . "<br>";
}

// Optionally set the first user as admin for testing
$sql_update = "UPDATE users SET role = 'admin' LIMIT 1";
if ($conn->query($sql_update) === TRUE) {
    echo "First user set as admin successfully.<br>";
}

$conn->close();
?>
