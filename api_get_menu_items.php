<?php
/**
 * API: Get Menu Items
 * Method: GET
 * Params: type (topbar, sidebar, footer)
 */

require_once 'db_connect.php';
header('Content-Type: application/json');

try {
    $type = isset($_GET['type']) ? $_GET['type'] : 'topbar';
    
    // Validate type
    if (!in_array($type, ['topbar', 'sidebar', 'footer'])) {
        throw new Exception('Loại menu không hợp lệ');
    }
    
    $sql = "SELECT id, type, title, url, icon, visible, position 
            FROM menu_items 
            WHERE type = ? 
            ORDER BY position ASC";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
    }
    
    $stmt->bind_param('s', $type);
    
    if (!$stmt->execute()) {
        throw new Exception('Lỗi thực thi query: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $items = [];
    
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $items,
        'type' => $type
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
