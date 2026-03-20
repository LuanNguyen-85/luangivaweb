<?php
/**
 * API: Update Menu Item
 * Method: POST
 * Params: id, title, url, icon, visible, position
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
    $title = isset($data['title']) ? trim($data['title']) : '';
    $url = isset($data['url']) ? trim($data['url']) : '';
    $icon = isset($data['icon']) ? trim($data['icon']) : '';
    $visible = isset($data['visible']) ? (bool)$data['visible'] : true;
    $position = isset($data['position']) ? (int)$data['position'] : 999;
    
    // Validation
    if ($id <= 0) {
        throw new Exception('ID menu không hợp lệ');
    }
    if (empty($title)) {
        throw new Exception('Tiêu đề menu không được để trống');
    }
    
    $sql = "UPDATE menu_items 
            SET title = ?, url = ?, icon = ?, visible = ?, position = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
    }
    
    $stmt->bind_param('sssii', $title, $url, $icon, $visible, $position, $id);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật menu: ' . $stmt->error);
    }
    
    if ($stmt->affected_rows === 0) {
        throw new Exception('Không tìm thấy menu item');
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật menu thành công'
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
