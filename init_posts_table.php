<?php
require 'db_connect.php';

// Tạo bảng posts nếu chưa tồn tại
$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    category VARCHAR(100),
    author_id INT,
    views INT DEFAULT 0,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'posts' đã được tạo/kiểm tra thành công.<br>";
} else {
    echo "Lỗi tạo bảng posts: " . $conn->error . "<br>";
}

$conn->close();
?>
