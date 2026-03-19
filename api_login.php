<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

// Nhận dữ liệu gửi từ JavaScript (Fetch API)
$data = json_decode(file_get_contents("php://input"));

if(isset($data->email) && isset($data->password)) {
    $email = $conn->real_escape_string($data->email);
    $password_input = $data->password;
    
    // Tìm người dùng trong CSDL bằng email
    $sql = "SELECT id, username, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // So sánh mật khẩu đã nhập với mật khẩu đã mã hóa trong DB
        if (password_verify($password_input, $row['password'])) {
            // Đăng nhập đúng, lưu vào Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            echo json_encode(["status" => "success", "message" => "Đăng nhập thành công!", "role" => $row['role']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Mật khẩu không chính xác."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tài khoản không tồn tại."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vui lòng cung cấp email và mật khẩu."]);
}
$conn->close();
?>
