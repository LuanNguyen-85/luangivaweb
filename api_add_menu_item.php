<?php
/**
 * API: Add Menu Item
 * Method: POST
 * Params: type, title, url, icon, visible, position
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
    
    $type = isset($data['type']) ? trim($data['type']) : '';
    $title = isset($data['title']) ? trim($data['title']) : '';
    $url = isset($data['url']) ? trim($data['url']) : '';
    $icon = isset($data['icon']) ? trim($data['icon']) : '';
    $visible = isset($data['visible']) ? (bool)$data['visible'] : true;
    $position = isset($data['position']) ? (int)$data['position'] : 999;
    
    // Validation
    if (empty($type) || !in_array($type, ['topbar', 'sidebar', 'footer'])) {
        throw new Exception('Loại menu không hợp lệ');
    }
    if (empty($title)) {
        throw new Exception('Tiêu đề menu không được để trống');
    }
    
    $sql = "INSERT INTO menu_items (type, title, url, icon, visible, position) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
    }
    
    $stmt->bind_param('ssssi', $type, $title, $url, $icon, $visible, $position);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thêm menu: ' . $stmt->error);
    }
    
    $new_id = $stmt->insert_id;
    
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Thêm menu thành công',
        'id' => $new_id
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
