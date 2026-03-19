<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới có quyền xóa user
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden: Admin only."]);
    exit;
}

require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["status" => "error", "message" => "Thiếu ID người dùng."]);
    exit;
}

$id = $conn->real_escape_string($data->id);

$sql = "DELETE FROM users WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Xóa người dùng thành công."]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
