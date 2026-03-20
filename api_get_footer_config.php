<?php
/**
 * API: Get Footer Config
 * Method: GET
 */

require_once 'db_connect.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT id, footer_text, visible FROM footer_config LIMIT 1";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception('Lỗi query: ' . $conn->error);
    }
    
    $config = $result->fetch_assoc();
    
    if (!$config) {
        // Return default if not found
        $config = [
            'id' => 0,
            'footer_text' => '© 2026 luangiva.com. All rights reserved.',
            'visible' => true
        ];
    }
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $config
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>
