<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'));
if (!isset($data->id)) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu ID bài viết.']);
    exit;
}

$id = $conn->real_escape_string($data->id);
$sql = "UPDATE posts SET views = views + 1 WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Đã tăng view.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $conn->error]);
}

$conn->close();
?>