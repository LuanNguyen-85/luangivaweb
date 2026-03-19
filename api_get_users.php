<?php
header('Content-Type: application/json');
require 'db_connect.php';

$sql = "SELECT id, username, email, role FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_index > 0 || $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);
$conn->close();
?>
