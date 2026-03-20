<?php
/**
 * Create test admin user
 */

require_once 'db_connect.php';

try {
    // Check if admin user already exists
    $check_sql = "SELECT id FROM users WHERE email = 'admin@luangiva.com' LIMIT 1";
    $result = $conn->query($check_sql);
    
    if ($result && $result->num_rows > 0) {
        echo "✓ Admin user đã tồn tại (admin@luangiva.com)<br>";
    } else {
        // Create admin user
        $email = 'admin@luangiva.com';
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $phone = '+84912345678';
        $role = 'admin';
        
        $insert_sql = "INSERT INTO users (username, email, password, phone, role) 
                       VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insert_sql);
        if (!$stmt) {
            throw new Exception('Lỗi chuẩn bị query: ' . $conn->error);
        }
        
        $stmt->bind_param('sssss', $username, $email, $password, $phone, $role);
        
        if (!$stmt->execute()) {
            throw new Exception('Lỗi tạo user: ' . $stmt->error);
        }
        
        echo "✓ Tạo admin user thành công!<br>";
        echo "<strong>Email:</strong> admin@luangiva.com<br>";
        echo "<strong>Password:</strong> admin123<br>";
        
        $stmt->close();
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage();
}

mysqli_close($conn);
?>
