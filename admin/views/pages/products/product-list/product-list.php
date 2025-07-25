<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="../../../../views/layout/layout-admin.css">
    <link rel="stylesheet" href="../../../../views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="../../../../views/layout/header/header.css">
    <link rel="stylesheet" href="../../../../views/pages/products/product-list/product-list.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <?php include_once(__DIR__ . "../../../../layout/sidebar/sidebar.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once(__DIR__ . "../../../../layout/header/header.php") ?>
            <div class="content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Quản lý sản phẩm</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Quản lý sản phẩm</h1>
                        </div>
                        <a href="index.php?router=admin/product/add" class="add-product-btn" id="addProductBtn">
                            <i class="fas fa-plus"></i> Thêm sản phẩm
                        </a>
                    </div>


                </div>
                <!-- Product Actions -->
                <div class="product-actions">
                    <form method="GET" action="index.php" class="product-filters">
                        <input type="hidden" name="router" value="admin/product">

                        <div class="filter-group">
                            <select class="filter-select" name="category">
                                <option value="">Tất cả danh mục</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= $category['danh_muc_id'] ?>"
                                        <?= isset($_GET['category']) && $_GET['category'] == $category['danh_muc_id'] ? 'selected' : '' ?>>
                                        <?= $category['ten_danh_muc'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <select class="filter-select" name="status">
                                <option value="">Tất cả trạng thái</option>
                                <option value="in-stock"
                                    <?= isset($_GET['status']) && $_GET['status'] == "in-stock" ? 'selected' : '' ?>>Còn
                                    hàng</option>
                                <option value="low-stock"
                                    <?= isset($_GET['status']) && $_GET['status'] == "low-stock" ? 'selected' : '' ?>>
                                    Hàng tồn kho ít</option>
                                <option value="out-of-stock"
                                    <?= isset($_GET['status']) && $_GET['status'] == "out-of-stock" ? 'selected' : '' ?>>
                                    Hết hàng</option>
                            </select>
                        </div>

                        <div class="filter-group">

                            <div class="search-container product-search">
                                <i class="fas fa-search search-icon"></i>
                                <input type="search" name="search" class="filter-input"
                                    value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
                                    placeholder="Tìm kiếm sản phẩm...">
                            </div>

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
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($product): ?>
                                <?php foreach ($product as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox-container">
                                                <input type="checkbox" id="product1">
                                                <label for="product1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="product-info">
                                                <div class="product-image">
                                                    <img src="assets/uploads/product/<?= $row["hinh"] ?>"
                                                        alt="<?= $row["hinh"] ?>">
                                                </div>
                                                <div class="product-details">
                                                    <p class="product-name"><?= $row["ten_san_pham"] ?></p>
                                                    <p class="product-id">ID: <?= $row["san_pham_id"] ?></p>
                                                    <p class="product-id">Mã sản phẩm: <?= $row["ma_san_pham"] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= formatCurrency($row["gia"], "vn") ?></td>
                                        <td><span
                                                class="status-badge <?= $row["trang_thai"] ?>"><?= formatProductStatus($row["trang_thai"]) ?></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?router=admin/product/edit&id=<?= $row["san_pham_id"] ?>"
                                                    class="action-btn edit-btn" data-id="<?= $row["san_pham_id"] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?router=admin/product/delete&id=<?= $row["san_pham_id"] ?>"
                                                    class="action-btn delete-btn"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')"
                                                    data-id="<?= $row["san_pham_id"] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <!-- Nút Previous -->
                    <?php if ($page > 1): ?>
                        <a href="?router=admin/product&page=<?= $page - 1 ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn pagination-disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    <?php endif; ?>

                    <?php if ($totalPages > 1): ?>
                        <a href="?router=admin/product&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>

                        <?php if ($page > 4): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                            <a href="?router=admin/product&page=<?= $i ?>"
                                class="pagination-btn <?= ($page == $i) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages - 3): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <a href="?router=admin/product&page=<?= $totalPages ?>"
                            class="pagination-btn <?= ($page == $totalPages) ? 'active' : '' ?>">
                            <?= $totalPages ?>
                        </a>
                    <?php else: ?>
                        <a href="?router=admin/product&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>
                    <?php endif; ?>

                    <!-- Nút Next -->
                    <?php if ($page < $totalPages): ?>
                        <a href="?router=admin/product&page=<?= $page + 1 ?>" class="pagination-btn">
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

    <script src="./views/layout/admin/layout-admin.js"></script>
</body>

</html>