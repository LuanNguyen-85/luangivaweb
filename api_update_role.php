<?php
header('Content-Type: application/json');
require 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->role)) {
    $id = $conn->real_escape_string($data->id);
    $role = $conn->real_escape_string($data->role);

    $sql = "UPDATE users SET role = '$role' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Cập nhật quyền thành công"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Thiếu thông tin"]);
}

$conn->close();
?>
