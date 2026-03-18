/**
 * STYLE & LOGIC SCRIPT
 * Theme: luangiva.com Dark Theme
 */

document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const sidebar = document.getElementById('sidebar');

    // Toggle Sidebar on Mobile
    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
        });
    }

    if (closeBtn && sidebar) {
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    }

    // Optional: Close sidebar when clicking outside of it on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Add glowing effect follow cursor on product cards (Micro-interaction)
    const cards = document.querySelectorAll('.product-card');
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Subtle radial gradient following the cursor
            card.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(0, 206, 201, 0.05) 0%, var(--bg-surface) 50%)`;
        });

        card.addEventListener('mouseleave', () => {
             card.style.background = 'var(--bg-surface)';
        });
    });

    // Topbar Tab Switching Logic
    const topbarLinks = document.querySelectorAll('.topbar-nav a');
    if (topbarLinks.length > 0) {
        topbarLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Có thể bỏ preventDefault nếu muốn cho link chuyển trang thật
                // e.preventDefault(); 
                
                // Remove active class from all
                topbarLinks.forEach(item => item.classList.remove('active'));
                
                // Add active to clicked
                link.classList.add('active');
            });
        });
    }

    // Admin Sidebar Tab Switching Logic
    const adminMenuLinks = document.querySelectorAll('.sidebar-menu .menu-item[data-target]');
    const adminPanels = document.querySelectorAll('.admin-panel');

    if (adminMenuLinks.length > 0 && adminPanels.length > 0) {
        adminMenuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all links
                adminMenuLinks.forEach(item => item.classList.remove('active'));
                
                // Add active class to clicked link
                link.classList.add('active');

                // Get target panel id
                const targetId = link.getAttribute('data-target');

                // Hide all panels
                adminPanels.forEach(panel => {
                    panel.classList.remove('active');
                });

                // Show target panel
                const targetPanel = document.getElementById(targetId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }

                // If on mobile, close the sidebar after clicking a tab
                if (window.innerWidth <= 768 && sidebar) {
                    sidebar.classList.remove('active');
                }
            });
        });
    }

    // Auth Logic cho Đăng nhập
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const btn = loginForm.querySelector('.auth-btn');
            
            const originalText = btn.textContent;
            btn.textContent = 'Đang xử lý...';
            btn.disabled = true;

            try {
                const response = await fetch('api_login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    alert('Đăng nhập thành công!');
                    window.location.href = 'index.html'; // Chuyển về trang chủ sau đăng nhập
                } else {
                    alert(data.message || 'Có lỗi xảy ra!');
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                alert('Lỗi kết nối máy chủ! Vui lòng kiểm tra lại mạng hoặc hosting.');
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    }

    // Auth Logic cho Đăng ký
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone')?.value || ''; // phone field might be specific
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const btn = registerForm.querySelector('button[type="submit"]');

            if (password !== confirmPassword) {
                alert('Mật khẩu nhập lại không khớp!');
                return;
            }
            
            const originalText = btn.textContent;
            btn.textContent = 'Đang xử lý...';
            btn.disabled = true;

            try {
                const response = await fetch('api_register.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, phone, password })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    alert('Đăng ký thành công! Vui lòng đăng nhập.');
                    window.location.href = 'login.html'; // Chuyển tới trang đăng nhập
                } else {
                    alert(data.message || 'Có lỗi xảy ra!');
                    btn.textContent = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                alert('Lỗi kết nối máy chủ! Vui lòng thử lại sau.');
                btn.textContent = originalText;
                btn.disabled = false;
            }
        });
    }
});

