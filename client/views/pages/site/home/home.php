<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/home/home.css">

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
        <section class="container box-slides">
            <div class="slider">
                <div class="slider-item">
                    <a href="#">
                        <img src="./assets/images/nike-banner-1.jpg">
                    </a>
                </div>
                <div class="slider-item">
                    <a href="#">
                        <img src="./assets/images/nike.webp">
                    </a>
                </div>
                <div class="slider-item">
                    <a href="#">
                        <img src="./assets/images/puma.webp">
                    </a>
                </div>
            </div>
        </section>

        <section class="brand-content">
            <div class="container">
                <div class="title-brand">
                    <h2>DANH SÁCH THƯƠNG HIỆU</h2>
                </div>
                <div class="brand-list">
                    <?php isset($brands) ?>
                    <?php foreach ($brands as $brand) : ?>
                        <a href="#" class="brand-box">
                            <span class="brand-link"><?= $brand['title'] ?></span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    <?php endforeach; ?>
                    <!-- <a class="brand-box">
                        <span class="brand-link">Thương hiệu 1</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a class="brand-box">
                        <span class="brand-link">Thương hiệu 1</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a class="brand-box">
                        <span class="brand-link">Thương hiệu 1</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a class="brand-box">
                        <span class="brand-link">Thương hiệu 1</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a class="brand-box">
                        <span class="brand-link">Thương hiệu 1</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a> -->
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products">
            <div class="container">
                <h2 class="section-title">SẢN PHẨM BÁN CHẠY</h2>

                <div class="product-grid">
                    <!-- Product -->
                    <?php if (isset($products_best_seller)): ?>
                        <?php foreach ($products_best_seller as $product): ?>
                            <a class="product-card" href="<?= BASE_URL . '?action=product_detail&slug=' . $product['slug'] ?>">
                                <!-- <div class="product-badge">-16%</div> -->
                                <div class="product-image">
                                    <img src="./assets/uploads/product/<?= $product['thumbnail'] ?>" he alt="<?= $product['title'] ?>">
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?= $product['title'] ?></h3>
                                    <div class="product-price">
                                        <span class="current-price"><?= formatCurrency($product['priceDefault'], "vn") ?></span>
                                        <!-- <span class="original-price">1,195,000₫</span> -->
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="featured-products">
            <div class="container">
                <h2 class="section-title">SẢN PHẨM THƯƠNG HIỆU HOT</h2>

                <div class="product-grid">
                    <!-- Product -->
                    <?php if (isset($products_brand_nike)): ?>
                        <?php foreach ($products_brand_nike as $product): ?>
                            <?php
                            // var_dump($product);
                            // die();
                            ?>
                            <a class="product-card" href="<?= BASE_URL . '?action=product_detail&slug=' . $product['slug'] ?>">
                                <!-- <div class="product-badge">-16%</div> -->
                                <div class="product-image">
                                    <img src="./assets/uploads/product/<?= $product['thumbnail'] ?>" he alt="<?= $product['title'] ?>">
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?= $product['title'] ?></h3>
                                    <div class="product-price">
                                        <span class="current-price"><?= formatCurrency($product['priceDefault'], "vn") ?></span>
                                        <!-- <span class="original-price">1,195,000₫</span> -->
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
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