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

    // Topbar Tab Switching Logic (Index page)
    const topbarLinks = document.querySelectorAll('.topbar-nav a');
    const featuredSection = document.getElementById('featuredSection');
    const postsSection = document.getElementById('postsSection');
    const postsGrid = document.getElementById('postsGrid');
    let publicPostsLoaded = false;

    function truncateText(str, maxLength = 150) {
        if (!str) return '';
        return str.length > maxLength ? str.slice(0, maxLength) + '...' : str;
    }

    function renderPublicPosts(posts) {
        if (!postsGrid) return;

        if (!Array.isArray(posts) || posts.length === 0) {
            postsGrid.innerHTML = `<div style="text-align:center; padding: 40px;"><p>Chưa có bài viết nào.</p></div>`;
            return;
        }

        postsGrid.innerHTML = posts.map(post => {
            const createdDate = post.created_date ? new Date(post.created_date).toLocaleDateString('vi-VN') : '';
            const preview = truncateText(post.content || '', 180);

            return `
                <article class="post-item">
                    <div class="post-header">
                        <span class="post-category">${post.category || 'Khác'}</span>
                        <h3 class="post-title">${post.title || 'Không có tiêu đề'}</h3>
                    </div>
                    <div class="post-content">${preview}</div>
                    <div class="post-footer">
                        <div class="post-date"><i class='bx bx-calendar'></i> ${createdDate}</div>
                        <div class="post-views"><i class='bx bx-show'></i> ${post.views || 0}</div>
                    </div>
                </article>
            `;
        }).join('');
    }

    async function loadPublicPosts() {
        if (!postsGrid) return;

        postsGrid.innerHTML = `<div style="text-align:center; padding: 40px;"><p>Đang tải bài viết...</p></div>`;

        try {
            const response = await fetch('api_get_posts.php');
            const posts = await response.json();

            if (!Array.isArray(posts)) {
                throw new Error('Định dạng dữ liệu không hợp lệ');
            }

            publicPostsLoaded = true;
            renderPublicPosts(posts);
        } catch (error) {
            console.error('loadPublicPosts failed', error);
            postsGrid.innerHTML = `<div style="text-align:center; padding: 40px;"><p style="color:#ff6b6b;">Không thể tải bài viết: ${error.message}</p></div>`;
        }
    }

    if (topbarLinks.length > 0) {
        topbarLinks.forEach(link => {
            link.addEventListener('click', async (e) => {
                // Có thể bỏ preventDefault nếu muốn cho link chuyển trang thật
                // e.preventDefault(); 
                
                // Remove active class from all
                topbarLinks.forEach(item => item.classList.remove('active'));
                
                // Add active to clicked
                link.classList.add('active');

                const targetId = link.getAttribute('data-target');

                // Show/hide index sections (Trang chủ / Bài viết)
                if (targetId === 'postsSection' && postsSection) {
                    if (featuredSection) featuredSection.style.display = 'none';
                    postsSection.style.display = 'block';
                    if (!publicPostsLoaded) {
                        await loadPublicPosts();
                    }
                } else {
                    if (featuredSection) featuredSection.style.display = 'block';
                    if (postsSection) postsSection.style.display = 'none';
                }
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
                    // Nếu là admin thì vào trang quản trị; nếu không thì về trang chủ
                    if (data.role === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        window.location.href = 'index.html';
                    }
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

    // ------------------------------------------------------------------
    // Load users for Admin panel (fetch từ api_get_users.php)
    // ------------------------------------------------------------------

    const userTableBody = document.getElementById('userTableBody');
    const userModal = document.getElementById('userModal');
    const userModalTitle = document.getElementById('userModalTitle');
    const userForm = document.getElementById('userForm');
    const userIdInput = document.getElementById('userId');
    const userNameInput = document.getElementById('userUsername');
    const userEmailInput = document.getElementById('userEmail');
    const userRoleSelect = document.getElementById('userRole');
    const userPhoneInput = document.getElementById('userPhone');
    const userPasswordInput = document.getElementById('userPassword');

    let currentUsers = [];

    async function loadUsers() {
        if (!userTableBody) return;

        userTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td></tr>`;

        try {
            const response = await fetch('api_get_users.php');
            const users = await response.json();

            if (!Array.isArray(users)) {
                throw new Error('Định dạng dữ liệu không hợp lệ');
            }

            currentUsers = users;

            if (users.length === 0) {
                userTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center;">Chưa có người dùng.</td></tr>`;
                return;
            }

            userTableBody.innerHTML = users.map(user => {
                const phone = user.phone ?? '';
                const role = user.role ?? '';
                return `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${phone}</td>
                        <td>${role}</td>
                        <td><span class="status active">Active</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon edit" data-user-id="${user.id}"><i class='bx bx-edit'></i></button>
                                <button class="btn-icon delete" data-user-id="${user.id}"><i class='bx bx-trash'></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        } catch (error) {
            console.error('loadUsers failed', error);
            userTableBody.innerHTML = `<tr><td colspan="7" style="text-align:center;color:#ff6b6b;">Không thể tải dữ liệu: ${error.message}</td></tr>`;
        }
    }

    function findUserById(id) {
        return currentUsers.find(u => String(u.id) === String(id));
    }

    function openUserModal(mode, user = null) {
        if (!userModal) return;

        userModal.dataset.mode = mode;

        if (mode === 'add') {
            userModalTitle.textContent = 'Thêm User mới';
            userIdInput.value = '';
            userNameInput.value = '';
            userEmailInput.value = '';
            userPhoneInput.value = '';
            userRoleSelect.value = 'user';
            userPasswordInput.value = '';
            userPasswordInput.required = true;
        } else if (mode === 'edit' && user) {
            userModalTitle.textContent = 'Chỉnh sửa User';
            userIdInput.value = user.id;
            userNameInput.value = user.username;
            userEmailInput.value = user.email;
            userPhoneInput.value = user.phone || '';
            userRoleSelect.value = user.role || 'user';
            userPasswordInput.value = '';
            userPasswordInput.required = false;
        }

        openModal('userModal');
    }

    async function saveUser() {
        const mode = userModal?.dataset?.mode;
        const id = userIdInput?.value;
        const username = userNameInput?.value?.trim();
        const email = userEmailInput?.value?.trim();
        const role = userRoleSelect?.value;
        const phone = userPhoneInput?.value?.trim();
        const password = userPasswordInput?.value;

        if (!username || !email) {
            alert('Vui lòng điền đầy đủ thông tin username và email.');
            return;
        }

        try {
            let url = 'api_register.php';
            let payload = { username, email, role, phone };

            if (mode === 'edit') {
                url = 'api_update_user.php';
                payload.id = id;
                if (password && password.length > 0) {
                    payload.password = password;
                }
            } else {
                // Add new user: password is required
                if (!password || password.length === 0) {
                    alert('Vui lòng nhập mật khẩu để tạo tài khoản.');
                    return;
                }
                payload.password = password;
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.status === 'success') {
                closeModal('userModal');
                await loadUsers();
                alert(data.message || 'Lưu thành công.');
            } else {
                alert(data.message || 'Có lỗi xảy ra khi lưu.');
            }
        } catch (error) {
            console.error('saveUser failed', error);
            alert('Không thể lưu dữ liệu. Vui lòng thử lại.');
        }
    }

    async function deleteUser(userId) {
        const confirmDelete = confirm('Bạn có chắc muốn xóa người dùng này?');
        if (!confirmDelete) return;

        try {
            const response = await fetch('api_delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId })
            });

            const data = await response.json();
            if (data.status === 'success') {
                await loadUsers();
                alert(data.message || 'Xóa thành công.');
            } else {
                alert(data.message || 'Không thể xóa user.');
            }
        } catch (error) {
            console.error('deleteUser failed', error);
            alert('Không thể xóa user. Vui lòng thử lại.');
        }
    }

    // Handle click events from table actions
    userTableBody?.addEventListener('click', (e) => {
        const editBtn = e.target.closest('button.edit');
        const deleteBtn = e.target.closest('button.delete');

        if (editBtn) {
            const userId = editBtn.getAttribute('data-user-id');
            const user = findUserById(userId);
            if (user) {
                openUserModal('edit', user);
            }
            return;
        }

        if (deleteBtn) {
            const userId = deleteBtn.getAttribute('data-user-id');
            deleteUser(userId);
            return;
        }
    });

    userForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        await saveUser();
    });

    // Expose openUserModal so the HTML button can call it
    window.openUserModal = openUserModal;

    // Load users when the users panel is activated
    const userPanelLink = document.querySelector('.sidebar-menu .menu-item[data-target="users"]');
    if (userPanelLink) {
        userPanelLink.addEventListener('click', () => {
            loadUsers();
        });
    }

    // If the users panel is already active on load, fetch right away
    if (document.getElementById('users')?.classList.contains('active')) {
        loadUsers();
    }

    // ------------------------------------------------------------------
    // Load posts for Admin panel (fetch từ api_get_posts.php)
    // ------------------------------------------------------------------

    const postTableBody = document.getElementById('postTableBody');
    const postModal = document.getElementById('postModal');
    const postModalTitle = document.getElementById('postModalTitle');
    const postForm = document.getElementById('postForm');
    const postIdInput = document.getElementById('postId');
    const postTitleInput = document.getElementById('postTitle');
    const postCategoryInput = document.getElementById('postCategory');
    const postContentInput = document.getElementById('postContent');

    let currentPosts = [];

    async function loadPosts() {
        if (!postTableBody) return;

        postTableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>`;

        try {
            const response = await fetch('api_get_posts.php?admin=1');
            const posts = await response.json();

            if (!Array.isArray(posts)) {
                throw new Error('Định dạng dữ liệu không hợp lệ');
            }

            currentPosts = posts;

            if (posts.length === 0) {
                postTableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Chưa có bài viết.</td></tr>`;
                return;
            }

            postTableBody.innerHTML = posts.map(post => {
                const createdDate = new Date(post.created_date).toLocaleDateString('vi-VN');
                return `
                    <tr>
                        <td>${post.id}</td>
                        <td>${post.title}</td>
                        <td>${post.category || 'N/A'}</td>
                        <td>${createdDate}</td>
                        <td>${post.views}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon edit" data-post-id="${post.id}"><i class='bx bx-edit'></i></button>
                                <button class="btn-icon delete" data-post-id="${post.id}"><i class='bx bx-trash'></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        } catch (error) {
            console.error('loadPosts failed', error);
            postTableBody.innerHTML = `<tr><td colspan="6" style="text-align:center;color:#ff6b6b;">Không thể tải dữ liệu: ${error.message}</td></tr>`;
        }
    }

    function findPostById(id) {
        return currentPosts.find(p => String(p.id) === String(id));
    }

    function openPostModal(mode, post = null) {
        if (!postModal) return;

        postModal.dataset.mode = mode;

        if (mode === 'add') {
            postModalTitle.textContent = 'Tạo Bài Viết Mới';
            postIdInput.value = '';
            postTitleInput.value = '';
            postCategoryInput.value = '';
            postContentInput.value = '';
        } else if (mode === 'edit' && post) {
            postModalTitle.textContent = 'Chỉnh sửa Bài Viết';
            postIdInput.value = post.id;
            postTitleInput.value = post.title;
            postCategoryInput.value = post.category || '';
            postContentInput.value = post.content;
        }

        openModal('postModal');
    }

    async function savePost() {
        const mode = postModal?.dataset?.mode;
        const id = postIdInput?.value;
        const title = postTitleInput?.value?.trim();
        const category = postCategoryInput?.value?.trim();
        const content = postContentInput?.value?.trim();

        if (!title || !content) {
            alert('Vui lòng điền đầy đủ tiêu đề và nội dung.');
            return;
        }

        try {
            let url = 'api_create_post.php';
            let payload = { title, category, content };

            if (mode === 'edit') {
                url = 'api_update_post.php';
                payload.id = id;
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.status === 'success') {
                closeModal('postModal');
                await loadPosts();
                alert(data.message || 'Lưu thành công.');
            } else {
                alert(data.message || 'Có lỗi xảy ra khi lưu.');
            }
        } catch (error) {
            console.error('savePost failed', error);
            alert('Không thể lưu dữ liệu. Vui lòng thử lại.');
        }
    }

    async function deletePost(postId) {
        const confirmDelete = confirm('Bạn có chắc muốn xóa bài viết này?');
        if (!confirmDelete) return;

        try {
            const response = await fetch('api_delete_post.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: postId })
            });

            const data = await response.json();
            if (data.status === 'success') {
                await loadPosts();
                alert(data.message || 'Xóa thành công.');
            } else {
                alert(data.message || 'Không thể xóa bài viết.');
            }
        } catch (error) {
            console.error('deletePost failed', error);
            alert('Không thể xóa bài viết. Vui lòng thử lại.');
        }
    }

    // Handle click events from table actions for posts
    postTableBody?.addEventListener('click', (e) => {
        const editBtn = e.target.closest('button.edit');
        const deleteBtn = e.target.closest('button.delete');

        if (editBtn) {
            const postId = editBtn.getAttribute('data-post-id');
            const post = findPostById(postId);
            if (post) {
                openPostModal('edit', post);
            }
            return;
        }

        if (deleteBtn) {
            const postId = deleteBtn.getAttribute('data-post-id');
            deletePost(postId);
            return;
        }
    });

    postForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        await savePost();
    });

    // Expose openPostModal so the HTML button can call it
    window.openPostModal = openPostModal;

    // Load posts when the posts panel is activated
    const postPanelLink = document.querySelector('.sidebar-menu .menu-item[data-target="posts"]');
    if (postPanelLink) {
        postPanelLink.addEventListener('click', () => {
            loadPosts();
        });
    }

    // If the posts panel is already active on load, fetch right away
    if (document.getElementById('posts')?.classList.contains('active')) {
        loadPosts();
    }
});

