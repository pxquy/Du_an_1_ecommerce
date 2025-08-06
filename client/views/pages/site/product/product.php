<?php extract($category); ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - <?= $ten_danh_muc ?></title>
    <link rel="stylesheet" href="./views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./views/pages/site/product/product.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Quí Super Shoes" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include_once("./views/layout/site/header-site/header-site.php") ?>
    <!-- Main Content - Products Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><?= $ten_danh_muc ?></li>
                </ul>
            </div>
        </div>

        <!-- Category Banner -->
        <div class="category-banner">
            <div class="container">
                <div class="category-banner-content">
                    <h1 class="category-title"><?= $ten_danh_muc ?></h1>
                    <p class="category-description">Khám phá bộ sưu tập <?= $ten_danh_muc ?> cao cấp, thiết kế tinh tế và chất lượng vượt trội từ Mulgati.</p>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <section class="products-section">
            <div class="container">
                <div class="products-container">


                    <!-- Products Content -->
                    <div class="products-content">
                        <!-- Products Toolbar -->
                        <div class="products-toolbar">
                            <div class="products-found">
                                <span id="productsCount"><?= $total ?></span> sản phẩm
                            </div>

                            <div class="products-sorting">
                                <label for="sortSelect">Sắp xếp:</label>
                                <select id="sortSelect" class="sort-select" onchange="handleSortChange()">
                                    <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Mặc định</option>
                                    <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>Giá: Thấp đến cao</option>
                                    <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>Giá: Cao đến thấp</option>
                                    <option value="name-asc" <?= $sort === 'name-asc' ? 'selected' : '' ?>>Tên: A-Z</option>
                                    <option value="name-desc" <?= $sort === 'name-desc' ? 'selected' : '' ?>>Tên: Z-A</option>
                                    <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                                </select>
                            </div>



                        </div>

                        <!-- Products Grid -->
                        <div class="products-grid" id="productsGrid">
                            <?php foreach ($products as $product): ?>
                                <div class="product-item">
                                    <div class="product-card">
                                        <div class="product-image">
                                            <a href="index.php?router=product-detail&id=<?= $product['san_pham_id'] ?>">
                                                <img src="./assets/uploads/product/<?= $product['hinh'] ?>" alt="<?= $product['ten_san_pham'] ?>">
                                            </a>
                                            <div class="product-actions">
                                                <button class="quick-view-btn" title="Xem nhanh"><a href="index.php?router=product-detail&id=<?= $product['san_pham_id'] ?>"><i class="fas fa-eye"></a></i></button>
                                                <button class="add-to-wishlist-btn" title="Thêm vào yêu thích"><i class="far fa-heart"></i></button>
                                                <button class="add-to-cart-btn" title="Thêm vào giỏ hàng"><i class="fas fa-shopping-bag"></i></button>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <h3 class="product-title">
                                                <a href="index.php?router=product-detail&id=<?= $product['san_pham_id'] ?>">
                                                    <?= $product['ten_san_pham'] ?>
                                                </a>
                                            </h3>
                                            <div class="product-price">
                                                <span class="current-price"><?= formatCurrency($product['gia'], 'vn') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                        <!-- Pagination -->
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a class="pagination-btn prev" href="?router=product&category_id=<?= $category_id ?>&page=<?= $page - 1 ?>&sort=<?= $sort ?>"><i class="fas fa-chevron-left"></i></a>
                            <?php else: ?>
                                <button class="pagination-btn prev" disabled><i class="fas fa-chevron-left"></i></button>
                            <?php endif; ?>

                            <div class="pagination-numbers">
                                <?php if ($totalPages > 1): ?>
                                    <a href="?router=product&category_id=<?= $category_id ?>&page=1&sort=<?= $sort ?>"
                                        class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>

                                    <?php if ($page > 4): ?>
                                        <span class="pagination-ellipsis">...</span>
                                    <?php endif; ?>

                                    <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                                        <a href="?router=product&category_id=<?= $category_id ?>&page=<?= $i ?>&sort=<?= $sort ?>"
                                            class="pagination-number <?= ($page == $i) ? 'active' : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages - 3): ?>
                                        <span class="pagination-ellipsis">...</span>
                                    <?php endif; ?>

                                    <a href="?router=product&category_id=<?= $category_id ?>&page=<?= $totalPages ?>&sort=<?= $sort ?>"
                                        class="pagination-number <?= ($page == $totalPages) ? 'active' : '' ?>">
                                        <?= $totalPages ?>
                                    </a>
                                <?php else: ?>
                                    <a href="?router=product&category_id=<?= $category_id ?>&page=1&sort=<?= $sort ?>"
                                        class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>
                                <?php endif; ?>
                            </div>

                            <?php if ($page < $totalPages): ?>
                                <a class="pagination-btn next" href="?router=product&category_id=<?= $category_id ?>&page=<?= $page + 1 ?>&sort=<?= $sort ?>"><i class="fas fa-chevron-right"></i></a>
                            <?php else: ?>
                                <button class="pagination-btn next" disabled><i class="fas fa-chevron-right"></i></button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once("./views/layout/site/footer-site/footer-site.php") ?>

    <script src="./views/layout/site/layout-site.js"></script>
    <script>
        function handleSortChange() {
            const sort = document.getElementById('sortSelect').value;
            const urlParams = new URLSearchParams(window.location.search);

            urlParams.set('sort', sort);
            urlParams.set('page', 1); // Reset về trang 1 khi sort mới

            window.location.search = urlParams.toString();
        }
    </script>

</body>

</html>