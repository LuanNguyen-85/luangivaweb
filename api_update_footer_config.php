<?php
/**
 * API: Update Footer Config
 * Method: POST
 * Params: footer_text, visible
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
    
    $footer_text = isset($data['footer_text']) ? trim($data['footer_text']) : '';
    $visible = isset($data['visible']) ? (bool)$data['visible'] : true;
    
    // Check if config exists
    $check_sql = "SELECT id FROM footer_config LIMIT 1";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        // Update existing
        $sql = "UPDATE footer_config SET footer_text = ?, visible = ?";
    } else {
        // Insert new
        $sql = "INSERT INTO footer_config (footer_text, visible) VALUES (?, ?)";
    }
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
    }
    
    $stmt->bind_param('si', $footer_text, $visible);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi cập nhật footer: ' . $stmt->error);
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật footer thành công'
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
