<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <a href="?action=/"><i class="fas fa-chart-bar"></i></a>
            <span class="logo-text">My Panel</span>
        </div>
    </div>
    <div class="sidebar-content">
        <nav class="sidebar-menu">
            <div class="menu-group">
                <h3 class="menu-title">Menu chính</h3>
                <ul class="menu-list">
                    <li
                        class="menu-item <?= ($_GET['action'] == 'userDashboardPage' || $_GET['action'] == 'userDashboardPage') ? 'active' : '' ?>">
                        <a href="?action=userDashboardPage" class="menu-link">
                            <i class="fas fa-home"></i>
                            <span class="menu-text">Thông tin cá nhân</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['action'] == 'update_info') ? 'active' : '' ?>">
                        <a href="?action=update_info" class="menu-link">
                            <i class="fas fa-users"></i>
                            <span class="menu-text">Thông tin tài khoản</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['action'] == 'userOrderPage') ? 'active' : '' ?>">
                        <a href="?action=userOrderPage" class="menu-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="menu-text">Đơn hàng</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu-group">
                <h3 class="menu-title">Hệ thống</h3>
                <ul class="menu-list">
                    <li class="menu-item <?= ($_GET['action'] == 'user/settings') ? 'active' : '' ?>">
                        <a href="?action=user/settings" class="menu-link">
                            <i class="fas fa-cog"></i>
                            <span class="menu-text">Cài đặt</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['action'] == 'user/help') ? 'active' : '' ?>">
                        <a href="?action=user/help" class="menu-link">
                            <i class="fas fa-question-circle"></i>
                            <span class="menu-text">Hỗ trợ</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="avatar">
                <img src="<?= isset($_SESSION['user']) ? './assets/uploads/user/' . $_SESSION['user']['avatarUrl'] : '' ?>" alt="User">
            </div>
            <div class="user-info">
                <span class="user-name"><?= isset($_SESSION['user']) ? $_SESSION['user']['fullname'] : '' ?></span>
                <span class="user-role">
                    <?= isset($_SESSION['user']) ? ($_SESSION['user']['role'] == 1 ? 'Admin' : 'User') : '' ?>
                </span>
            </div>
            <a href="<?= BASE_URL . '?action=logout' ?>"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>

    </div>
</aside>