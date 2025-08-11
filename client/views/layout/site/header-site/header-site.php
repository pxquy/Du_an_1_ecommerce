<?php
$this->brands = new Brand();
$brands = $this->brands->select();
?>


<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-content">
            <div class="top-bar-left">
                <span>DANH SÁCH CỬA HÀNG</span>
            </div>
            <div class="top-bar-right">
                <span>Hotline liên hệ: 1900 1234</span>
                <span class="divider">|</span>
                <span>cskh@quisupershoes.com</span>
            </div>
        </div>
    </div>
</div>

<!-- Header - Now Sticky with Mobile Menu and User Dropdown -->
<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="<?= BASE_URL ?>">
                    <img src="./assets/images/logoShop.png" width="150" alt="Quí Super Shoes">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="main-nav">
                <ul class="nav-list">
                    <?php if (isset($brands)): ?>
                        <?php foreach ($brands as $brand): ?>
                            <li class="nav-item"><a href="index.php?router=product&category_id=<?= $brand["title"] ?>"><a href="<?= BASE_URL . '?action=product-brand&brandId=' . $brand['id'] ?>"><?= $brand['title'] ?></a></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <!-- Search Icon with Dropdown -->
                <div class="search-dropdown">
                    <button class="search-icon-btn">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-dropdown-content">
                        <form class="search-form" method="GET" action="<?= BASE_URL ?>">
                            <input type="hidden" name="action" value="search">

                            <div class="col-md-3">
                                <input type="text" name="keyword" class="search-input"
                                    placeholder="Nhập từ khoá tìm kiếm..."
                                    value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                            </div>

                            <button type="submit" class="search-submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>

                        <div class="search-suggestions">
                            <h4>Tìm kiếm phổ biến:</h4>
                            <div class="suggestion-tags">
                                <a href="#" class="suggestion-tag">Giày thể thao nike</a>
                                <a href="#" class="suggestion-tag">Giày chạy bộ puma</a>
                                <a href="#" class="suggestion-tag">Giày bóng rổ</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Account Dropdown -->
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle">
                        <?php if (isset($_SESSION['user'])) : ?>
                            <!-- User avatar for logged in state (hidden by default) -->
                            <div class="user-avatar logged-in">
                                <img src="./assets/upload/users/<?= $_SESSION['user']['avatarUrl'] ?>" height="40" width="40" alt="User Avatar">
                            </div>
                        <?php else : ?>
                            <!-- User icon for logged out state (default) -->
                            <div class="user-icon logged-out">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif ?>
                    </button>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <!-- Dropdown Menu - Logged In State (hidden by default) -->
                        <div class="user-dropdown-menu logged-in">
                            <div class="user-greeting">Xin chào, <span class="user-name"><?= $_SESSION['user']['fullname'] ?></span></div>
                            <a href="<?= isset($_SESSION['user']) &&  $_SESSION['user']['role'] == 1 ? BASE_URL_ADMIN : BASE_URL ?>" class="dropdown-item">Trang quản trị</a>
                            <a href="<?= BASE_URL . '?action=logout' ?>" class="dropdown-item logout-btn">Đăng xuất</a>
                        </div>
                    <?php else : ?>
                        <!-- Dropdown Menu - Logged Out State (default) -->
                        <div class="user-dropdown-menu logged-out">
                            <a href="<?= BASE_URL . '?action=form_signin' ?>" class="dropdown-item">Đăng nhập</a>
                            <a href="<?= BASE_URL . '?action=signup' ?>" class="dropdown-item">Đăng ký</a>
                        </div>
                    <?php endif ?>
                </div>

                <a href="<?= BASE_URL . '?action=my_cart' ?>" class="cart-icon">
                    <i class="fas fa-shopping-bag"></i>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <span class="cart-count"><?= isset($cartCount) ? $cartCount : 0 ?></span>

                    <?php endif ?>
                </a>

                <!-- Mobile Menu Toggle Button -->
                <button class="mobile-menu-toggle">
                    <span class="hamburger-icon">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Search Overlay for Mobile -->
<div class="search-overlay"></div>

<!-- Mobile Navigation Menu -->
<div class="mobile-menu">
    <div class="mobile-menu-header">
        <div class="logo">
            <img src="./assets/images/logo-shop.webp" width="120" alt="Quí Super Shoes">
        </div>
        <button class="mobile-menu-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="mobile-nav">
        <ul class="mobile-nav-list">
            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <li class="mobile-nav-item"><a href="index.php?router=product&category_id=<?= $category["danh_muc_id"] ?>"><?= $category['ten_danh_muc'] ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- <li class="mobile-nav-item mobile-dropdown">
                    <a href="#" class="mobile-dropdown-toggle">
                        PHỤ KIỆN <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="mobile-dropdown-menu">
                        <li><a href="#">Thắt Lưng</a></li>
                        <li><a href="#">Ví Da</a></li>
                        <li><a href="#">Túi Xách</a></li>
                    </ul>
                </li> -->
        </ul>
    </nav>
    <div class="mobile-menu-footer">
        <div class="mobile-contact">
            <p><i class="fas fa-phone"></i> 1900 1234</p>
            <p><i class="fas fa-envelope"></i> cskh@quisupershoes.com</p>
        </div>
        <div class="mobile-social">
            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>

<!-- Overlay for Mobile Menu -->
<div class="mobile-menu-overlay"></div>