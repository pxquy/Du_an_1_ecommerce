<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/product-brand/product-brand.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Quí Super Shoes" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />

    <!-- Add Slick Slider CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php require_once("./client/views/layout/site/header-site/header-site.php"); ?>
    <!-- Main Content Wrapper -->
    <main class="main-content">
        <!-- Hero Banner -->
        <!-- Hero Banner Slider -->
        <section class="container box-welcome">
            <div class="welcome">
                <span>Khám phá bộ sưu tập <?= $title ?> cao cấp, thiết kế tinh tế và chất lượng vượt trội từ Arrowwai</span>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products">
            <div class="container">
                <h2 class="section-title">SẢN PHẨM THƯƠNG HIỆU <?= $title ?></h2>

                <div class="product-grid">
                    <?php
                    $list = $brandList ?? $products ?? [];
                    if (is_array($list) && !empty($list)) :
                        foreach ($list as $product):
                    ?>
                            <a class="product-card" href="<?= BASE_URL . '?action=product_detail&slug=' . $product['slug'] ?>">
                                <div class="product-image">
                                    <img src="<?= BASE_ASSETS_UPLOADS . $product['thumbnail'] ?>" alt="<?= $product['title'] ?>">
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?= $product['title'] ?></h3>
                                    <div class="product-price">
                                        <span class="current-price"><?= formatCurrency($product['priceDefault'], "vn") ?></span>
                                    </div>
                                </div>
                            </a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <div class="reviews-pagination">
            <?php if ($page > 1): ?>
                <a class="pagination-btn prev"
                    href="?action=product-brand&brandId=<?= $brandId ?>&page=<?= $page - 1 ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php else: ?>
                <button class="pagination-btn prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
            <?php endif; ?>

            <div class="pagination-numbers">
                <?php if ($totalPages > 1): ?>
                    <!-- Trang 1 -->
                    <a href="?action=product-brand&brandId=<?= $brandId ?>&page=1"
                        class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>

                    <!-- Dấu ... phía trước -->
                    <?php if ($page > 4): ?>
                        <span class="pagination-ellipsis">...</span>
                    <?php endif; ?>

                    <!-- Các trang ở giữa -->
                    <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                        <a href="?action=product-brand&brandId=<?= $brandId ?>&page=<?= $i ?>"
                            class="pagination-number <?= ($page == $i) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Dấu ... phía sau -->
                    <?php if ($page < $totalPages - 3): ?>
                        <span class="pagination-ellipsis">...</span>
                    <?php endif; ?>

                    <!-- Trang cuối -->
                    <a href="?action=product-brand&brandId=<?= $brandId ?>&page=<?= $totalPages ?>"
                        class="pagination-number <?= ($page == $totalPages) ? 'active' : '' ?>">
                        <?= $totalPages ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($page < $totalPages): ?>
                <a class="pagination-btn next"
                    href="?action=product-brand&brandId=<?= $brandId ?>&page=<?= $page + 1 ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <button class="pagination-btn next" disabled>
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php endif; ?>
        </div>

    </main>
    <?php include_once("./client/views/layout/site/footer-site/footer-site.php") ?>

    <script src="./client/views/layout/site/layout-site.js"></script>
    <script>
        $(document).ready(function() {
            $(".slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                draggable: true,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: true,
                dots: true,
                prevArrow: '<i class="fa-solid fa-chevron-left"></i>',
                nextArrow: '<i class="fa-solid fa-chevron-right"></i>',
                responsive: [{
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                    }
                }]
            });
        })
    </script>
</body>

</html>