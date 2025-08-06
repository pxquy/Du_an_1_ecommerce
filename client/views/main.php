<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Trang chủ' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="<?= BASE_URL ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL . "?action=logout" ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container mt-4">
        <h2 class="text-center mb-4">Tìm kiếm sản phẩm</h2>

        <!-- Form tìm kiếm -->
        <form class="row g-2 mb-4" method="GET">
            <input type="hidden" name="action" value="search">

            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..."
                    value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <input type="number" name="minPrice" class="form-control" placeholder="Giá tối thiểu"
                    value="<?= htmlspecialchars($_GET['minPrice'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <input type="number" name="maxPrice" class="form-control" placeholder="Giá tối đa"
                    value="<?= htmlspecialchars($_GET['maxPrice'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <select name="order" class="form-select">
                    <option value="ASC" <?= (($_GET['order'] ?? '') == 'ASC') ? 'selected' : '' ?>>A-Z</option>
                    <option value="DESC" <?= (($_GET['order'] ?? '') == 'DESC') ? 'selected' : '' ?>>Z-A</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>
        </form>

        <!-- Bảng kết quả -->
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Slug</th>
                    <th>Ngày tạo</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product['thumbnail'])): ?>
                                    <img src="<?= $product['thumbnail'] ?>" alt="Ảnh" width="60">
                                <?php else: ?>
                                    <span>Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['title']) ?></td>
                            <td><?= number_format($product['priceDefault'], 0, ',', '.') ?> đ</td>
                            <td><?= htmlspecialchars($product['slug']) ?></td>
                            <td><?= htmlspecialchars($product['createdAt']) ?></td>
                            <td>
                                <a href="<?= BASE_URL . '?action=product_detail&id=' . $product['id'] ?>"
                                    class="btn btn-sm btn-info">Chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Không tìm thấy sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>

</html>