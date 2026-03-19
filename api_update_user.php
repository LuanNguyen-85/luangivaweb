<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới có quyền cập nhật user
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

$fields = [];
if (isset($data->username)) {
    $fields[] = "username = '" . $conn->real_escape_string($data->username) . "'";
}
if (isset($data->email)) {
    $fields[] = "email = '" . $conn->real_escape_string($data->email) . "'";
}
if (isset($data->role)) {
    $fields[] = "role = '" . $conn->real_escape_string($data->role) . "'";
}

if (isset($data->phone)) {
    $fields[] = "phone = '" . $conn->real_escape_string($data->phone) . "'";
}

if (isset($data->password) && trim($data->password) !== '') {
    $passwordHash = password_hash($data->password, PASSWORD_BCRYPT);
    $fields[] = "password = '" . $conn->real_escape_string($passwordHash) . "'";
}

if (empty($fields)) {
    echo json_encode(["status" => "error", "message" => "Không có trường dữ liệu để cập nhật."]);
    exit;
}

$sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Cập nhật người dùng thành công."]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
