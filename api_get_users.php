<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới được xem danh sách user
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden: Admin only."]);
    exit;
}

require 'db_connect.php';

$sql = "SELECT id, username, email, role, phone FROM users";
$result = $conn->query($sql);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);
$conn->close();
?>
