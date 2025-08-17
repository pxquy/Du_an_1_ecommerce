<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-chart-bar"></i>
            <span class="logo-text">Admin Panel</span>
        </div>
    </div>
    <div class="sidebar-content">
        <nav class="sidebar-menu">
            <div class="menu-group">
                <h3 class="menu-title">DANH MỤC</h3>
                <ul class="menu-list">
                    <li class="menu-item <?= !$view ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN ?>" class="menu-link">
                            <i class="fas fa-home"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item <?= $view == 'users/index' ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>" class="menu-link">
                            <i class="fas fa-users"></i>
                            <span class="menu-text">Người dùng</span>
                        </a>
                    </li>
                    <li class="menu-item <?= $view == 'categories/index' ? 'active' : "" ?> ">
                        <a href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>" class="menu-link">
                            <i class="fa-regular fa-rectangle-list"></i>
                            <span class="menu-text">Danh mục</span>
                        </a>
                    </li>
                    <li class="menu-item <?= $view == 'brands/index' ? 'active' : "" ?> ">
                        <a href="<?= BASE_URL_ADMIN . '&action=brands-index' ?>" class="menu-link">
                            <i class="fa-regular fa-copyright"></i>
                            <span class="menu-text">Thương hiệu</span>
                        </a>
                    </li>
                    <!-- <li class="menu-item <?= $view == 'vouchers/index' ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN . '&action=vouchers-index' ?>" class="menu-link">
                            <i class="fa-regular fa-file-powerpoint"></i>
                            <span class="menu-text">Khuyến mãi</span>
                        </a>
                    </li> -->
                    <li class="menu-item <?= $view == 'products/index' ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="menu-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="menu-text">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="menu-item <?= $view == 'orders/index' ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN . '&action=orders-index' ?>" class="menu-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="menu-text">Đơn hàng</span>
                        </a>
                    </li>
                    <li class="menu-item <?= $view == 'comments/index' ? 'active' : "" ?>">
                        <a href="<?= BASE_URL_ADMIN . '&action=comments-index' ?>" class="menu-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="menu-text">Bình luận</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= BASE_URL_ADMIN . '&action=attributes-index' ?>" class="menu-link">
                            <i class="fas fa-file-alt"></i>
                            <span class="menu-text">Thuộc tính</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu-group">
                <h3 class="menu-title">HỆ THỐNG</h3>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-cog"></i>
                            <span class="menu-text">Cài đặt</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
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
                <?php if ($_SESSION['user']['avatarUrl']): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $_SESSION['user']['avatarUrl'] ?>" alt="User" />
                <?php endif ?>
            </div>
            <div class="user-info">
                <span class="user-name"><?= $_SESSION['user']['fullname'] ?></span>
                <span
                    class="user-role"><?= $_SESSION['user']['role'] == 1 ? 'Admin' : ($_SESSION['user']['role'] == 2 ? 'Staff' : 'Khách Hàng') ?></span>
            </div>
            <a href="<?= BASE_URL ?>">
                <i class="fas fa-sign-out-alt logout-icon"></i>
            </a>

        </div>
    </div>
</aside>