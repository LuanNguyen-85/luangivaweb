<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới được xem danh sách bài viết khi truy cập từ admin
$fromAdmin = isset($_GET['admin']) && $_GET['admin'] === '1';

if ($fromAdmin && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden: Admin only."]);
    exit;
}

require 'db_connect.php';

$sql = "SELECT id, title, content, category, author_id, views, created_date FROM posts ORDER BY created_date DESC";
$result = $conn->query($sql);

$posts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

echo json_encode($posts);
$conn->close();
?>
