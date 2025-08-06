<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Bảng điều khiển</title>
    <link rel="stylesheet" href="./views/layout/user/layout-user.css">
    <link rel="stylesheet" href="./views/layout/user/sidebar-user/sidebar-user.css">
    <link rel="stylesheet" href="./views/layout/user/header-user/header-user.css">
    <link rel="stylesheet" href="./views/pages/user/dashboard/dashboard.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include_once("./views/layout/user/sidebar-user/sidebar-user.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once("./views/layout/user/header-user/header-user.php") ?>
            <!-- Dashboard Content -->
            <div class="content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Bảng điểu khiển</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Bảng điểu khiển</h1>
                            <!-- <p class="content-description">Welcome back! Here's an overview of your admin dashboard.</p> -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="text">
                        <h2>CHÀO MỪNG QUAY TRỞ LẠI, <?= $_SESSION['user']['ho_va_ten'] ?></h2>
                        <p><i>Tổng quát các hoạt động của bạn tại đây</i></p>
                    </div>
                    <img class="icon" src="./assets/images/icon-account-home.png">
                </div>

                <div class="charts-grid">
                    <div class="chart-card revenue-chart">
                        <div class="chart-header">
                            <h3 class="chart-title">Thông tin</h3>
                            <p class="chart-description">Thông tin của bạn</p>
                        </div>
                        <div class="chart-content">
                            <div class="account-box">
                                <div class="account-info">
                                    <div class="tools">
                                        <a href="index.php?router=user/information"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </div>
                                    <ul class="info-list">
                                        <li><span>Họ tên:</span> <strong><?= $_SESSION['user']['ho_va_ten'] ?></strong></li>
                                        <li><span>Giới tính:</span> <strong><?= FormatGender($_SESSION['user']['gioi_tinh']) ?></strong></li>
                                        <li><span>Số điện thoại:</span> <strong><?= $_SESSION['user']['so_dien_thoai'] ?></strong></li>
                                        <li><span>Email:</span> <strong><?= $_SESSION['user']['email'] ?></i></strong></li>
                                        <li><span>Địa chỉ:</span> <strong><?= $_SESSION['user']['dia_chi'] ?></strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-card orders-chart">
                        <div class="chart-header">
                            <h3 class="chart-title">Đơn đặt hàng gần đây</h3>
                            <p class="chart-description">Đơn hàng mới nhất của bạn</p>
                        </div>
                        <div class="chart-content">
                            <div class="orders-list">
                                <?php foreach ($recentOrders as $order) : ?>
                                    <div class="order-item">
                                        <div class="order-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="order-info">
                                            <p class="order-name">Đơn hàng #QSS<?= $order['don_hang_id'] ?></p>
                                            <p class="order-customer"><?= $order['ho_va_ten'] ?></p>
                                        </div>
                                        <div class="order-price"><?= formatCurrency($order['tong_tien'], 'vn') ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="./views/layout/user/layout-user.js"></script>

</body>

</html>