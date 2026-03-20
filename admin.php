<?php
session_start();
// Only admins can access the admin panel
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUANGIVA - Quản Trị Hệ Thống</title>
    <!-- Modern Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- BoxIcons for lightweight SVG icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="app-container">
        <!-- Admin Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon admin-icon"><i class='bx bx-shield-quarter'></i></div>
                    <h2>ADMIN PANEL</h2>
                </div>
                <button class="close-btn" id="close-btn" aria-label="Đóng menu"><i class='bx bx-x'></i></button>
            </div>

            <div class="sidebar-menu">
                <span class="menu-label">TỔNG QUAN</span>
                <a href="#dashboard" class="menu-item active" data-target="dashboard">
                    <i class='bx bxs-dashboard' style="color: #00cec9;"></i>
                    <span>Dashboard</span>
                </a>

                <span class="menu-label mt-4">QUẢN LÝ TÀI KHOẢN</span>
                <a href="#users" class="menu-item" data-target="users">
                    <i class='bx bxs-user-detail' style="color: #4facfe;"></i>
                    <span>Quản lý User</span>
                </a>
                <a href="#collaborators" class="menu-item" data-target="collaborators">
                    <i class='bx bxs-group' style="color: #fccb90;"></i>
                    <span>Cộng tác viên</span>
                </a>

                <span class="menu-label mt-4">NỘI DUNG SẢN PHẨM</span>
                <a href="#posts" class="menu-item" data-target="posts">
                    <i class='bx bxs-edit' style="color: #ff9a9e;"></i>
                    <span>Bài viết</span>
                </a>
                <a href="#products" class="menu-item" data-target="products">
                    <i class='bx bxs-cart' style="color: #84fab0;"></i>
                    <span>Sản phẩm</span>
                </a>
                <a href="#documents" class="menu-item" data-target="documents">
                    <i class='bx bxs-folder-open' style="color: #f6d365;"></i>
                    <span>Tài liệu</span>
                </a>

                <span class="menu-label mt-4">CHUYÊN MỤC CẤP CAO</span>
                <a href="#courses" class="menu-item" data-target="courses">
                    <i class='bx bxs-graduation' style="color: #a18cd1;"></i>
                    <span>Khóa học</span>
                </a>
                <a href="#zoom-events" class="menu-item" data-target="zoom-events">
                    <i class='bx bxs-video' style="color: #ff6b6b;"></i>
                    <span>Sự kiện Zoom</span>
                </a>
                <a href="#pricing" class="menu-item" data-target="pricing">
                    <i class='bx bx-money' style="color: #cfd9df;"></i>
                    <span>Bảng giá</span>
                </a>

                <span class="menu-label mt-4">AI & CHATBOT</span>
                <a href="#chatbot-prompts" class="menu-item" data-target="chatbot-prompts">
                    <i class='bx bx-message-rounded-dots' style="color: #e0c3fc;"></i>
                    <span>Chatbot Prompt</span>
                </a>
                <a href="#chatbot-ai" class="menu-item" data-target="chatbot-ai">
                    <i class='bx bx-bot' style="color: #8fd3f4;"></i>
                    <span>Chatbot AI</span>
                </a>
                <a href="#ai-system" class="menu-item" data-target="ai-system">
                    <i class='bx bx-brain' style="color: #ff4757;"></i>
                    <span>Hệ thống AI</span>
                </a>

                <span class="menu-label mt-4">CẤU HÌNH GIAO DIỆN</span>
                <a href="#theme-settings" class="menu-item" data-target="theme-settings">
                    <i class='bx bx-paint-roll' style="color: #fca5a5;"></i>
                    <span>Menu / Topbar / Footbar</span>
                </a>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <main class="main-wrapper">
            <!-- Topbar Header -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-btn" id="menu-btn" aria-label="Mở menu"><i class='bx bx-menu'></i></button>
                    <nav class="topbar-nav">
                        <span class="admin-title">Hệ thống Quản Trị LUANGIVA</span>
                    </nav>
                </div>
                <div class="topbar-right">
                    <a href="index.html" class="btn btn-outline-cyan"><i class='bx bx-world'></i> Xem trang web</a>
                    <a href="login.html" class="btn btn-red" aria-label="Đăng xuất"><i class='bx bx-log-out'></i> Đăng xuất</a>
                </div>
            </header>

            <!-- Main Content Container -->
            <div class="content admin-content">

                <!-- PANEL: DASHBOARD -->
                <section id="dashboard" class="admin-panel active">
                    <div class="section-header">
                        <h2><i class='bx bxs-dashboard'></i> Tổng quan hệ thống</h2>
                    </div>
                    <div class="admin-dashboard-cards">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);"><i class='bx bxs-user'></i></div>
                            <div class="stat-info">
                                <h3>1,254</h3>
                                <p>Tổng người dùng</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #ff9a9e, #fecfef);"><i class='bx bxs-cart'></i></div>
                            <div class="stat-info">
                                <h3>320</h3>
                                <p>Sản phẩm & Khóa học</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #f6d365, #fda085);"><i class='bx bx-money'></i></div>
                            <div class="stat-info">
                                <h3>$15,400</h3>
                                <p>Doanh thu tháng</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);"><i class='bx bx-bot'></i></div>
                            <div class="stat-info">
                                <h3>65</h3>
                                <p>Chatbot & Prompt AI</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- PANEL: USERS (User, email, phone) -->
                <section id="users" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-user-detail'></i> Quản lý Người dùng</h2>
                        <button class="btn btn-cyan" onclick="openUserModal('add')"><i class='bx bx-plus'></i> Thêm User mới</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên người dùng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Phân quyền</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <!-- Dữ liệu người dùng sẽ được đổ vào đây từ script.js -->
                                <tr>
                                    <td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: COLLABORATORS -->
                <section id="collaborators" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-group'></i> Trang Cộng tác viên</h2>
                        <button class="btn btn-cyan"><i class='bx bx-plus'></i> Thêm Chính sách / Info</button>
                    </div>
                    <div class="admin-form-group">
                        <label>Nội dung trang Cộng tác viên (Trình soạn thảo)</label>
                        <textarea rows="10" placeholder="Viết nội dung giới thiệu, chính sách hoa hồng..."></textarea>
                    </div>
                    <button class="btn btn-purple">Lưu Thay Đổi</button>
                </section>

                <!-- PANEL: POSTS -->
                <section id="posts" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-edit'></i> Quản lý Bài viết</h2>
                        <button class="btn btn-cyan" onclick="openPostModal('add')"><i class='bx bx-plus'></i> Tạo Bài Viết Mới</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Danh mục</th>
                                    <th>Ngày đăng</th>
                                    <th>Lượt xem</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="postTableBody">
                                <tr>
                                    <td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: PRODUCTS -->
                <section id="products" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-cart'></i> Quản lý Sản phẩm</h2>
                        <button class="btn btn-cyan"><i class='bx bx-plus'></i> Thêm Sản Phẩm Mới</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Tên Sản phẩm</th>
                                    <th>Loại</th>
                                    <th>Giá (VNĐ)</th>
                                    <th>Luợt Bán</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Con Trùng Tạo CR7 Siêu Đỉnh</td>
                                    <td>Chatbot</td>
                                    <td>199.000đ</td>
                                    <td>10</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                            <button class="btn-icon delete"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: DOCUMENTS -->
                <section id="documents" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-folder-open'></i> Quản lý Tài liêu</h2>
                        <button class="btn btn-cyan"><i class='bx bx-upload'></i> Upload Tài liệu mới</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Tên Tài liệu</th>
                                    <th>Định dạng</th>
                                    <th>Dung lượng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Bộ Prompt Design chuyên nghiệp 2026</td>
                                    <td>PDF</td>
                                    <td>5.2 MB</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                            <button class="btn-icon delete"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: COURSES -->
                <section id="courses" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-graduation'></i> Quản lý Khóa học</h2>
                        <button class="btn btn-cyan"><i class='bx bx-plus'></i> Thêm Khóa Học</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Tên Khóa Học</th>
                                    <th>Giảng viên</th>
                                    <th>Số bài học</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Master Class: Trí tuệ Nhân tạo Cơ bản</td>
                                    <td>Luangiva Admin</td>
                                    <td>12 Video</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                            <button class="btn-icon delete"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: ZOOM EVENTS -->
                <section id="zoom-events" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bxs-video'></i> Thông tin Sự kiện Zoom</h2>
                    </div>
                    <div class="admin-form-group">
                        <label>Tên Sự kiện</label>
                        <input type="text" value="Workshop: Khai thác AI cho Doanh nghiệp">
                    </div>
                    <div class="admin-form-group">
                        <label>Đường link tham gia Zoom</label>
                        <input type="url" value="https://zoom.us/j/123456789">
                    </div>
                    <div class="admin-form-group">
                        <label>Mật khẩu phòng (nếu có)</label>
                        <input type="text" value="luangiva2026">
                    </div>
                    <div class="admin-form-group">
                        <label>Thời gian bắt đầu</label>
                        <input type="datetime-local">
                    </div>
                    <button class="btn btn-purple">Lưu / Cập Nhật Sự Kiện</button>
                </section>

                <!-- PANEL: PRICING -->
                <section id="pricing" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bx-money'></i> Chỉnh sửa Bảng giá (Pricing)</h2>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Tên gói</th>
                                    <th>Giá</th>
                                    <th>Chu kỳ</th>
                                    <th>Tính năng Nổi bật</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gói Cơ Bản</td>
                                    <td>199.000đ</td>
                                    <td>Tháng</td>
                                    <td>Chatbot cơ bản, 10 Prompt</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gói Premium (HOT)</td>
                                    <td>499.000đ</td>
                                    <td>Tháng</td>
                                    <td>Chatbot AI PRO, Download Unlimited</td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: CHATBOT PROMPT -->
                <section id="chatbot-prompts" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bx-message-rounded-dots'></i> Quản lý Chatbot Prompt</h2>
                        <button class="btn btn-cyan"><i class='bx bx-plus'></i> Thêm Prompt Mới</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Tên Prompt</th>
                                    <th>Mô tả</th>
                                    <th>Danh mục</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Marketing Content Generator</td>
                                    <td>Tạo nội dung viral cho mạng xã hội</td>
                                    <td>Marketing</td>
                                    <td><span class="status active">Active</span></td>
                                    <td>
                                        <div class="action-btns">
                                            <button class="btn-icon edit"><i class='bx bx-edit'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- PANEL: CHATBOT AI -->
                <section id="chatbot-ai" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bx-bot'></i> Quản lý Chatbot AI Models</h2>
                        <button class="btn btn-cyan"><i class='bx bx-plus'></i> Tích hợp Model mới</button>
                    </div>
                    <div class="admin-form-group">
                        <label>Tên Bot (Hiển thị UI)</label>
                        <input type="text" placeholder="Ví dụ: LuanGiva Assistant">
                    </div>
                    <div class="admin-form-group">
                        <label>Hành vi mặc định (System Prompt)</label>
                        <textarea rows="4" placeholder="Nhập instructions cho bot..."></textarea>
                    </div>
                    <button class="btn btn-purple">Cập nhật Cấu hình AI</button>
                </section>

                <!-- PANEL: AI SYSTEM -->
                <section id="ai-system" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bx-brain'></i> Cấu hình Hệ thống AI (Core)</h2>
                    </div>
                    <div class="admin-form-group">
                        <label>Bật/Tắt AI Toàn cầu</label>
                        <select>
                            <option>Đang Bật (Kích hoạt cho tất cả User)</option>
                            <option>Tắt (Chỉ Admin mới được dùng)</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>OpenAI/LLM API Key</label>
                        <input type="password" value="********************************">
                    </div>
                    <div class="admin-form-group">
                        <label>Giới hạn Request (Rate Limit)</label>
                        <input type="number" value="100">
                    </div>
                    <button class="btn btn-purple">Lưu Hệ Thống AI</button>
                </section>

                <!-- PANEL: THEME SETTINGS -->
                <section id="theme-settings" class="admin-panel">
                    <div class="admin-header-actions">
                        <h2><i class='bx bx-paint-roll'></i> Quản lý / Chỉnh sửa Menu, Topbar, Footbar</h2>
                    </div>
                    
                    <!-- Topbar Menu Configuration -->
                    <h3 style="margin-bottom: 12px; font-size: 16px;">Tùy chỉnh Topbar Menu</h3>
                    <div class="admin-form-group" style="margin-bottom: 16px;">
                        <button class="btn btn-cyan" onclick="openMenuItemModal('add', 'topbar')"><i class='bx bx-plus'></i> Thêm mục Topbar</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Vị trí</th>
                                    <th>Tiêu đề</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Hiên/Ẩn</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="topbarMenuTable">
                                <tr><td colspan="6" style="text-align:center;">Đang tải...</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Sidebar Menu Configuration -->
                    <h3 style="margin-bottom: 12px; margin-top: 24px; font-size: 16px;">Tùy chỉnh Sidebar Menu</h3>
                    <div class="admin-form-group" style="margin-bottom: 16px;">
                        <button class="btn btn-cyan" onclick="openMenuItemModal('add', 'sidebar')"><i class='bx bx-plus'></i> Thêm mục Sidebar</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Vị trí</th>
                                    <th>Tiêu đề</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Hiên/Ẩn</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="sidebarMenuTable">
                                <tr><td colspan="6" style="text-align:center;">Đang tải...</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Configuration -->
                    <h3 style="margin-bottom: 12px; margin-top: 24px; font-size: 16px;">Tùy chỉnh Footer</h3>
                    <div class="admin-form-group">
                        <label>Nội dung bản quyền Footer</label>
                        <input type="text" id="footerText" placeholder="© 2026 luangiva.com. All rights reserved.">
                    </div>
                    <div class="admin-form-group">
                        <label>
                            <input type="checkbox" id="footerVisible" checked>
                            Hiển thị Footer
                        </label>
                    </div>
                    <button class="btn btn-purple" onclick="updateFooterConfig()">Lưu Cập Nhật Footer</button>
                </section>

            </div>
        </main>
    </div>

    <!-- Modal Form Quản lý User (Thêm / Chỉnh sửa) -->
    <div class="admin-modal" id="userModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="userModalTitle">Quản lý User</h2>
                <button class="close-btn" onclick="closeModal('userModal')" style="display:block; font-size:24px;"><i class='bx bx-x'></i></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId">
                    <div class="admin-form-group">
                        <label>Username</label>
                        <input id="userUsername" type="text" placeholder="Tên tài khoản" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Email</label>
                        <input id="userEmail" type="email" placeholder="Email" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Số điện thoại</label>
                        <input id="userPhone" type="tel" placeholder="Số điện thoại">
                    </div>
                    <div class="admin-form-group">
                        <label>Phân quyền</label>
                        <select id="userRole">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="admin-form-group" id="passwordGroup">
                        <label>Mật khẩu</label>
                        <input id="userPassword" type="password" placeholder="Mật khẩu">
                        <small id="passwordHint" style="opacity:.8; font-size:12px;">(Chỉ cần nhập khi tạo mới hoặc muốn đổi mật khẩu)</small>
                    </div>
                    <button type="submit" class="btn btn-cyan" style="width: 100%; justify-content:center;" id="userModalSubmitBtn">Lưu</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Quản lý Post (Thêm / Chỉnh sửa) -->
    <div class="admin-modal" id="postModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="postModalTitle">Quản lý Bài Viết</h2>
                <button class="close-btn" onclick="closeModal('postModal')" style="display:block; font-size:24px;"><i class='bx bx-x'></i></button>
            </div>
            <div class="modal-body">
                <form id="postForm">
                    <input type="hidden" id="postId">
                    <div class="admin-form-group">
                        <label>Tiêu đề</label>
                        <input id="postTitle" type="text" placeholder="Tiêu đề bài viết" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Danh mục</label>
                        <input id="postCategory" type="text" placeholder="Danh mục (ví dụ: Thủ thuật AI)">
                    </div>
                    <div class="admin-form-group">
                        <label>Ảnh đại diện (URL)</label>
                        <input id="postImageUrl" type="text" placeholder="https://...">
                    </div>
                    <div class="admin-form-group">
                        <label>Nội dung</label>
                        <textarea id="postContent" rows="8" placeholder="Nhập nội dung bài viết" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-cyan" style="width: 100%; justify-content:center;" id="postModalSubmitBtn">Lưu Bài Viết</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Menu Item (Thêm / Chỉnh sửa) -->
    <div class="admin-modal" id="menuItemModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="menuItemModalTitle">Quản lý Menu Item</h2>
                <button class="close-btn" onclick="closeModal('menuItemModal')" style="display:block; font-size:24px;"><i class='bx bx-x'></i></button>
            </div>
            <div class="modal-body">
                <form id="menuItemForm">
                    <input type="hidden" id="menuItemId">
                    <input type="hidden" id="menuItemType">
                    <div class="admin-form-group">
                        <label>Tiêu đề</label>
                        <input id="menuItemTitle" type="text" placeholder="Tiêu đề mục menu" required>
                    </div>
                    <div class="admin-form-group">
                        <label>URL</label>
                        <input id="menuItemUrl" type="text" placeholder="https://... hoặc /path">
                    </div>
                    <div class="admin-form-group">
                        <label>Icon (BoxIcon class, vd: bx-home, bxs-user)</label>
                        <input id="menuItemIcon" type="text" placeholder="bxs-home">
                    </div>
                    <div class="admin-form-group">
                        <label>Vị trí (số thứ tự)</label>
                        <input id="menuItemPosition" type="number" value="0" min="0">
                    </div>
                    <div class="admin-form-group">
                        <label>
                            <input type="checkbox" id="menuItemVisible" checked>
                            Hiển thị
                        </label>
                    </div>
                    <button type="submit" class="btn btn-cyan" style="width: 100%; justify-content:center;" id="menuItemModalSubmitBtn">Lưu</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Logic Script -->
    <script src="script.js"></script>
    <script>
        // Inline JS logic specific for Admin Panel (Modal & Tabs are globalized in script.js)
        function openModal(id) {
            document.getElementById(id).classList.add('show');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
        }
    </script>
</body>

</html>
