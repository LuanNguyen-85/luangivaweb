<?php
/**
 * API: Delete Menu Item
 * Method: POST
 * Params: id
 * Protected: Admin only
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

try {
    // Admin check
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        throw new Exception('Chỉ admin mới có quyền');
    }
    
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = isset($data['id']) ? (int)$data['id'] : 0;
    
    // Validation
    if ($id <= 0) {
        throw new Exception('ID menu không hợp lệ');
    }
    
    $sql = "DELETE FROM menu_items WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
    }
    
    $stmt->bind_param('i', $id);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi xóa menu: ' . $stmt->error);
    }
    
    if ($stmt->affected_rows === 0) {
        throw new Exception('Không tìm thấy menu item');
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Xóa menu thành công'
    ]);
    
    $stmt->close();
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>
