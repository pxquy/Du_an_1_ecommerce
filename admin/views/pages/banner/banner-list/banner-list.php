<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý trình chiếu</title>
    <link rel="stylesheet" href="./views/layout/layout-admin.css">
    <link rel="stylesheet" href="./views/layout/sidebar/sidebar.css">
    <link rel="stylesheet" href="./views/layout/header/header.css">
    <link rel="stylesheet" href="./views/pages/banner/banner-list/banner-list.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Add overlay div -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include_once("./views/layout/sidebar/sidebar.php") ?>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <?php include_once("./views/layout/header/header.php") ?>
            <div class="content">
                <div class="content-header">
                    <div class="breadcrumb">
                        <i class="fas fa-home breadcrumb-separator"></i>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-current">Quản lý banner</span>
                    </div>
                    <div class="content-wrapper">
                        <div class="content-text">
                            <h1 class="content-title">Quản lý banner</h1>
                        </div>
                        <a href="index.php?router=admin/slides/add" class="add-product-btn" id="addProductBtn">
                            <i class="fas fa-plus"></i> Thêm banner
                        </a>
                    </div>


                </div>
                <!-- Product Actions -->
                <div class="product-actions">
                    <form method="GET" action="index.php" class="product-filters">
                        <input type="hidden" name="router" value="admin/slides">

                        <div class="filter-group">
                            <select class="filter-select" name="status">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1"
                                    <?= isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                <option value="2"
                                    <?= isset($_GET['status']) && $_GET['status'] == 2 ? 'selected' : '' ?>>Không hoạt động</option>
                            </select>
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
                                <th>ID</th>
                                <th>Hình</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($slides): ?>
                                <?php foreach ($slides as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox-container">
                                                <input type="checkbox" id="product1">
                                                <label for="product1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $row["trinh_chieu_id"] ?>
                                        </td>
                                        <td> <img class="image-preview" src="assets/uploads/slides/<?= $row["hinh"] ?>"
                                                alt="<?= $row["hinh"] ?>"></td>
                                        <td><span
                                                class="status-badge <?= $row["trang_thai"] == 1 ? 'in-stock' : 'out-of-stock' ?>"><?= $row["trang_thai"] == 1 ? 'Hoạt động' : 'Không hoạt động' ?></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?router=admin/slides/edit&id=<?= $row["trinh_chieu_id"] ?>"
                                                    class="action-btn edit-btn" data-id="<?= $row["trinh_chieu_id"] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?router=admin/slides/delete&id=<?= $row["trinh_chieu_id"] ?>"
                                                    class="action-btn delete-btn"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xoá trình chiếu này không?')"
                                                    data-id="<?= $row["trinh_chieu_id"] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có banner nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <!-- Nút Previous -->
                    <?php if ($page > 1): ?>
                        <a href="?router=admin/slides&page=<?= $page - 1 ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn pagination-disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    <?php endif; ?>

                    <?php if ($totalPages > 1): ?>
                        <a href="?router=admin/slides&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>

                        <?php if ($page > 4): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                            <a href="?router=admin/slides&page=<?= $i ?>"
                                class="pagination-btn <?= ($page == $i) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages - 3): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>

                        <a href="?router=admin/slides&page=<?= $totalPages ?>"
                            class="pagination-btn <?= ($page == $totalPages) ? 'active' : '' ?>">
                            <?= $totalPages ?>
                        </a>
                    <?php else: ?>
                        <a href="?router=admin/slides&page=1"
                            class="pagination-btn <?= ($page == 1) ? 'active' : '' ?>">1</a>
                    <?php endif; ?>

                    <!-- Nút Next -->
                    <?php if ($page < $totalPages): ?>
                        <a href="?router=admin/slides&page=<?= $page + 1 ?>" class="pagination-btn">
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

    <script src="./views/layout/layout-admin.js"></script>
</body>

</html>