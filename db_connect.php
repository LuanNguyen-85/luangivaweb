<?php
$servername = "localhost";
$username = "root"; // Thay bằng tên User mà bạn tạo ở Bước 2
$password = ""; // Thay bằng mật khẩu của User bạn tạo
$dbname = "luangiva_local_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}
$conn->set_charset("utf8");
?>
