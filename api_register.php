<?php
header('Content-Type: application/json');
require 'db_connect.php';

// Nhận dữ liệu gửi từ JavaScript (Fetch API)
$data = json_decode(file_get_contents("php://input"));

if(isset($data->email) && isset($data->password)) {
    $email = $conn->real_escape_string($data->email);
    
    // Tách email để lấy username mặc định
    $username_parts = explode('@', $email);
    $username = $conn->real_escape_string($username_parts[0]);
    
    // Mã hóa mật khẩu
    $password = password_hash($data->password, PASSWORD_BCRYPT);
    
    // Kiểm tra xem email đã tồn tại chưa
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($check_sql);
    if($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email này đã được sử dụng."]);
        exit();
    }
    
    // Ghi vào Database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Đăng ký thành công!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi hệ thống: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin."]);
}
$conn->close();
?>
