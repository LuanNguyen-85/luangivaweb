<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới được cập nhật bài viết
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden: Admin only."]);
    exit;
}

require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["status" => "error", "message" => "Thiếu ID bài viết."]);
    exit;
}

$id = $conn->real_escape_string($data->id);
$fields = [];

if (isset($data->title)) {
    $fields[] = "title = '" . $conn->real_escape_string($data->title) . "'";
}
if (isset($data->content)) {
    $fields[] = "content = '" . $conn->real_escape_string($data->content) . "'";
}
if (isset($data->category)) {
    $fields[] = "category = '" . $conn->real_escape_string($data->category) . "'";
}

if (empty($fields)) {
    echo json_encode(["status" => "error", "message" => "Không có trường dữ liệu để cập nhật."]);
    exit;
}

$sql = "UPDATE posts SET " . implode(', ', $fields) . " WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Cập nhật bài viết thành công."]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
