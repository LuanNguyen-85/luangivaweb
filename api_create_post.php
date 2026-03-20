<?php
session_start();
header('Content-Type: application/json');

// Chỉ admin mới được tạo bài viết
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Forbidden: Admin only."]);
    exit;
}

require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->title) || !isset($data->content)) {
    echo json_encode(["status" => "error", "message" => "Thiếu tiêu đề hoặc nội dung."]);
    exit;
}

$title = $conn->real_escape_string($data->title);
$content = $conn->real_escape_string($data->content);
$category = isset($data->category) ? $conn->real_escape_string($data->category) : '';
$image_url = isset($data->image_url) ? $conn->real_escape_string($data->image_url) : '';
$author_id = $_SESSION['user_id'];

$sql = "INSERT INTO posts (title, content, category, image_url, author_id) VALUES ('$title', '$content', '$category', '$image_url', '$author_id')";

if ($conn->query($sql) === TRUE) {
    $post_id = $conn->insert_id;
    echo json_encode(["status" => "success", "message" => "Bài viết tạo thành công.", "post_id" => $post_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
