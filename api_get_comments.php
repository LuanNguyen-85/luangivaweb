<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

$post_id = isset($_GET['post_id']) ? $conn->real_escape_string($_GET['post_id']) : null;
if (!$post_id) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu post_id.']);
    exit;
}

$sql = "SELECT id, post_id, name, content, created_date FROM comments WHERE post_id = '$post_id' ORDER BY created_date DESC";
$result = $conn->query($sql);
$comments = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

echo json_encode($comments);
$conn->close();
?>