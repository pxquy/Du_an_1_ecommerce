<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - 404</title>
    <link rel="stylesheet" href="./views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./views/pages/site/404/404.css">

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
    <!-- Main Content - 404 Page -->
    <main class="main-content">
        <div class="not-found-container">
            <div class="not-found-content">
                <div class="error-code">404</div>
                <h1 class="error-title">Không tìm thấy trang</h1>
                <p class="error-message">Rất tiếc, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.</p>

                <!-- <div class="error-illustration">
                    <img src="/placeholder.svg?height=250&width=400" alt="404 Illustration">
                </div> -->

                <div class="error-actions">
                    <a href="index.php?router=home" class="back-home-btn">
                        <i class="fas fa-home"></i> Về trang chủ
                    </a>
                    <a href="#" class="contact-btn">
                        <i class="fas fa-envelope"></i> Liên hệ hỗ trợ
                    </a>
                </div>

                <div class="search-suggestion">
                    <p>Hoặc tìm kiếm sản phẩm:</p>
                    <form class="error-search-form">
                        <input type="text" placeholder="Nhập từ khóa tìm kiếm..." class="error-search-input">
                        <button type="submit" class="error-search-btn">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </form>
                </div>

                <div class="popular-links">
                    <h3>Các trang phổ biến:</h3>
                    <div class="popular-links-grid">
                        <a href="#" class="popular-link">
                            <i class="fas fa-shoe-prints"></i>
                            <span>Giày da nam</span>
                        </a>
                        <a href="#" class="popular-link">
                            <i class="fas fa-percentage"></i>
                            <span>Khuyến mãi</span>
                        </a>
                        <a href="#" class="popular-link">
                            <i class="fas fa-tshirt"></i>
                            <span>Bộ sưu tập mới</span>
                        </a>
                        <a href="#" class="popular-link">
                            <i class="fas fa-store"></i>
                            <span>Cửa hàng</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("./views/layout/site/footer-site/footer-site.php") ?>

    <script src="./views/layout/site/layout-site.js"></script>
</body>

</html>