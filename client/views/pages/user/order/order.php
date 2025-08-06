<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - Đơn hàng đã đặt</title>
    <link rel="stylesheet" href="./views/layout/user/layout-user.css">
    <link rel="stylesheet" href="./views/layout/user/sidebar-user/sidebar-user.css">
    <link rel="stylesheet" href="./views/layout/user/header-user/header-user.css">
    <link rel="stylesheet" href="./views/pages/user/order/order.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
            <div class="content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Đơn hàng đã đặt</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Đơn hàng đã đặt</h1>
                            <!-- <p class="content-description">Manage your products inventory, add new products, and update
                                existing ones.</p> -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="text">
                            <h2>CHÀO MỪNG QUAY TRỞ LẠI, <?= $_SESSION['user']['ho_va_ten'] ?></h2>
                            <p><i>Kiểm tra thông tin đơn hàng của bạn tại đây</i></p>
                        </div>
                        <img class="icon" src="./assets/images/icon-account-order.png">
                    </div>

                </div>
                <!-- Product Actions -->
                <div class="product-actions">
                    <form method="GET" action="index.php" class="product-filters">
                        <input type="hidden" name="router" value="user/orders">

                        <div class="filter-group">
                            <label for="trang_thai" class="filter-label">Trạng thái</label>
                            <select class="filter-select" id="trang_thai" name="trang_thai">
                                <option value="" <?= empty($_GET['trang_thai']) ? 'selected' : '' ?>>Tất cả trạng thái</option>
                                <option value="1" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '1') ? 'selected' : '' ?>>Chờ xác nhận</option>
                                <option value="2" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '2') ? 'selected' : '' ?>>Đang xử lý</option>
                                <option value="3" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '3') ? 'selected' : '' ?>>Đang giao hàng</option>
                                <option value="4" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '4') ? 'selected' : '' ?>>Thành công</option>
                                <option value="5" <?= (isset($_GET['trang_thai']) && $_GET['trang_thai'] == '5') ? 'selected' : '' ?>>Huỷ</option>
                            </select>

                        </div>

                        <div class="filter-group">
                            <label for="ngay_bat_dau" class="filter-label">Ngày bắt đầu</label>
                            <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="filter-input"
                                value="<?= isset($_GET['ngay_bat_dau']) ? $_GET['ngay_bat_dau'] : '' ?>"
                                placeholder="Ngày bắt đầu">
                        </div>

                        <div class="filter-group">
                            <label for="ngay_ket_thuc" class="filter-label">Ngày kết thúc</label>
                            <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="filter-input"
                                value="<?= isset($_GET['ngay_ket_thuc']) ? $_GET['ngay_ket_thuc'] : '' ?>"
                                placeholder="Ngày kết thúc">
                        </div>


                        <button type="submit" class="filter-product-btn">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                    </form>

                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </div>
                                </th>
                                <th>Mã đơn hàng</th>
                                <th>Tên khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($orders): ?>
                                <?php foreach ($orders as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox-container">
                                                <input type="checkbox" id="product1">
                                                <label for="product1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-details">
                                                <p class="product-name">#QSS<?= $row["don_hang_id"] ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-details">
                                                <p class="product-name"><?= $row["ho_va_ten"] ?></p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-details">
                                                <p class="product-name"><?= date("d/m/Y", strtotime($row["ngay_dat"])) ?></p>
                                            </div>
                                        </td>
                                        <td><?= formatCurrency($row["tong_tien"], "vn") ?></td>
                                        <td><span
                                                class="status-badge <?= formatClassOrderStatus($row["trang_thai"]) ?>"><?= formatOrderStatus($row["trang_thai"]) ?></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?router=user/orders/detail&id=<?= $row["don_hang_id"] ?>"
                                                    class="action-btn edit-btn" data-id="<?= $row["don_hang_id"] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($row["trang_thai"] == 1 || $row["trang_thai"] == 2) : ?>
                                                    <a href="index.php?router=user/orders/cancel&id=<?= $row["don_hang_id"] ?>"
                                                        class="action-btn delete-btn"
                                                        onclick="return confirm('Bạn có chắc chắn huỷ đơn hàng này không?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($row["trang_thai"] == 3) : ?>
                                                    <a href="index.php?router=user/orders/confirm&id=<?= $row["don_hang_id"] ?>"
                                                        class="action-btn confirm-btn"
                                                        onclick="return confirm('Bạn đã nhận được hàng và trả tiền cho người bán?')">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination">
                    <!-- Nút Previous -->
                    <?php if ($page > 1): ?>
                        <a href="?router=user/orders&page=<?= $page - 1 ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn pagination-disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    <?php endif; ?>

                    <?php if ($totalPages > 1): ?>
                        <a href="?router=user/orders&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>

                        <?php if ($page > 4): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                            <a href="?router=user/orders&page=<?= $i ?>"
                                class="pagination-btn <?= ($page == $i) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages - 3): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <a href="?router=user/orders&page=<?= $totalPages ?>"
                            class="pagination-btn <?= ($page == $totalPages) ? 'active' : '' ?>">
                            <?= $totalPages ?>
                        </a>
                    <?php else: ?>
                        <a href="?router=user/orders&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>
                    <?php endif; ?>

                    <!-- Nút Next -->
                    <?php if ($page < $totalPages): ?>
                        <a href="?router=user/orders&page=<?= $page + 1 ?>" class="pagination-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn pagination-disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="./views/layout/user/layout-user.js"></script>

    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<script>toastr.error("' . $_SESSION['error_message'] . '")</script>';
        unset($_SESSION['error_message']);
    }
    ?>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<script>toastr.success("' . $_SESSION['success_message'] . '")</script>';
        unset($_SESSION['success_message']);
    }
    ?>
</body>

</html>