<?php
/**
 * Initialize Menu Configuration Tables
 * Creates tables for managing menu items and footer configuration
 */

require_once 'db_connect.php';

try {
    // Create menu_items table
    $sql_menu = "
    CREATE TABLE IF NOT EXISTS menu_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type ENUM('topbar', 'sidebar', 'footer') NOT NULL,
        title VARCHAR(150) NOT NULL,
        url VARCHAR(255),
        icon VARCHAR(50),
        visible BOOLEAN DEFAULT TRUE,
        position INT DEFAULT 0,
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_menu (type, position)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    ";
    
    $conn->query($sql_menu);
    echo "✓ Bảng menu_items đã được tạo/cộng lại.<br>";
    
    // Create footer_config table
    $sql_footer = "
    CREATE TABLE IF NOT EXISTS footer_config (
        id INT AUTO_INCREMENT PRIMARY KEY,
        footer_text TEXT,
        visible BOOLEAN DEFAULT TRUE,
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    ";
    
    $conn->query($sql_footer);
    echo "✓ Bảng footer_config đã được tạo/cộng lại.<br>";
    
    // Clear existing menu items and insert default data
    $conn->query("DELETE FROM menu_items");
    $conn->query("DELETE FROM footer_config");
    
    // Insert default topbar menu items
    $default_topbar = [
        ['Trang chủ', '/', 'bxs-home', 1],
        ['Công cụ AI', '/tools', 'bx-wrench', 1],
        ['Đăng ký', 'register.html', 'bx-log-in', 1],
    ];
    
    $position = 0;
    foreach ($default_topbar as $item) {
        $conn->query("INSERT INTO menu_items (type, title, url, icon, visible, position) 
                      VALUES ('topbar', '{$item[0]}', '{$item[1]}', '{$item[2]}', {$item[3]}, {$position})");
        $position++;
    }
    echo "✓ Dữ liệu topbar menu mặc định đã được tạo.<br>";
    
    // Insert default footer config
    $conn->query("INSERT INTO footer_config (footer_text, visible) 
                  VALUES ('© 2026 luangiva.com. All rights reserved.', TRUE)");
    echo "✓ Dữ liệu footer mặc định đã được tạo.<br>";
    
    echo "<h3 style='color: green; margin-top: 16px;'>✓ Khởi tạo bảng menu thành công!</h3>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</h3>";
}

mysqli_close($conn);
?>
