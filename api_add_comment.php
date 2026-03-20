<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents('php://input'));
if (!isset($data->post_id) || !isset($data->name) || !isset($data->content)) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu bình luận.']);
    exit;
}
$post_id = $conn->real_escape_string($data->post_id);
$name = $conn->real_escape_string($data->name);
$content = $conn->real_escape_string($data->content);

$sql = "INSERT INTO comments (post_id, name, content) VALUES ('$post_id', '$name', '$content')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Bình luận đã được gửi.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $conn->error]);
}

$conn->close();
?>