<?php
$servername = "localhost";
$username = "root"; // Thay bằng tên User mà bạn tạo ở Bước 2
$password = ""; // Thay bằng mật khẩu của User bạn tạo
$dbname = "luangiva_local_db";

// Xác nhận extension mysqli đã bật (nếu không sẽ gây fatal error khi cố gắng tạo mysqli)
if (!extension_loaded('mysqli') || !class_exists('mysqli')) {
    if (php_sapi_name() !== 'cli') {
        header('Content-Type: application/json');
        http_response_code(500);
    }
    echo json_encode([
        "status" => "error",
        "message" => "Server configuration error: missing mysqli extension."
    ]);
    exit;
}

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    if (php_sapi_name() !== 'cli') {
        header('Content-Type: application/json');
        http_response_code(500);
    }
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}
$conn->set_charset("utf8");
?>
