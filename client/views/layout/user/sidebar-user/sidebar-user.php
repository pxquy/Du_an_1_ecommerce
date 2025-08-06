<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <a href="index.php?router=home"><i class="fas fa-chart-bar"></i></a>
            <span class="logo-text">My Panel</span>
        </div>
    </div>
    <div class="sidebar-content">
        <nav class="sidebar-menu">
            <div class="menu-group">
                <h3 class="menu-title">Menu chính</h3>
                <ul class="menu-list">
                    <li
                        class="menu-item <?= ($_GET['router'] == 'user/dashboard' || $_GET['router'] == 'user') ? 'active' : '' ?>">
                        <a href="index.php?router=user/dashboard" class="menu-link">
                            <i class="fas fa-home"></i>
                            <span class="menu-text">Bảng điều khiển</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['router'] == 'user/information') ? 'active' : '' ?>">
                        <a href="index.php?router=user/information" class="menu-link">
                            <i class="fas fa-users"></i>
                            <span class="menu-text">Thông tin tài khoản</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['router'] == 'user/orders') ? 'active' : '' ?>">
                        <a href="index.php?router=user/orders" class="menu-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="menu-text">Đơn hàng</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu-group">
                <h3 class="menu-title">Hệ thống</h3>
                <ul class="menu-list">
                    <li class="menu-item <?= ($_GET['router'] == 'user/settings') ? 'active' : '' ?>">
                        <a href="index.php?router=user/settings" class="menu-link">
                            <i class="fas fa-cog"></i>
                            <span class="menu-text">Cài đặt</span>
                        </a>
                    </li>
                    <li class="menu-item <?= ($_GET['router'] == 'user/help') ? 'active' : '' ?>">
                        <a href="index.php?router=user/help" class="menu-link">
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
                <img src="<?= isset($_SESSION['user']) ? './assets/uploads/user/' . $_SESSION['user']['hinh'] : '' ?>" alt="User">
            </div>
            <div class="user-info">
                <span class="user-name"><?= isset($_SESSION['user']) ? $_SESSION['user']['ho_va_ten'] : '' ?></span>
                <span class="user-role">
                    <?= isset($_SESSION['user']) ? ($_SESSION['user']['vai_tro'] == 1 ? 'Admin' : 'User') : '' ?>
                </span>
            </div>
            <a href="index.php?router=logout"><i class="fas fa-sign-out-alt logout-icon"></i></a>
        </div>

    </div>
</aside>