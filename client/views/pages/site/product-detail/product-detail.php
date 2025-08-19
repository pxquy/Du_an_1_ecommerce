<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./client/views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./client/views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./client/views/pages/site/product-detail/product-detail.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Arrowwai" />
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
    <?php include_once("./client/views/layout/site/header-site/header-site.php") ?>
    <!-- Main Content - Product Detail Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><a href="index.php?router=product&category_id=<?= $productDetail['categoryId'] ?>"><?= $productDetail["title"] ?></a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><?= $title ?></li>
                </ul>
            </div>
        </div>

        <!-- Product Detail Section -->
        <section class="product-detail-section">
            <div class="container">
                <div class="product-detail-container">
                    <!-- Product Gallery -->
                    <div class="product-gallery">
                        <div>
                            <!-- Main Gallery -->
                            <div class="gallery-main">
                                <div class="swiper gallery-main-swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="gallery-image">
                                                <img src="<?= BASE_ASSETS_UPLOADS . $productDetail["thumbnail"] ?>" alt="<?= $title ?>" id="zoom-image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-thumbs">
                            <div class="swiper gallery-thumbs-swiper">
                                <div class="swiper-box">
                                    <?php foreach ($images as $image) : ?>
                                        <div class="swiper-slide">
                                            <div class="thumb-image">
                                                <img
                                                    src="<?= BASE_ASSETS_UPLOADS . $image ?>"
                                                    alt="<?= $title ?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <!-- <div class="swiper-slide">
                                        <div class="thumb-image">
                                            <img
                                                src="/placeholder.svg?height=120&width=120"
                                                alt="Thumbnail 2" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="thumb-image">
                                            <img
                                                src="/placeholder.svg?height=120&width=120"
                                                alt="Thumbnail 3" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="thumb-image">
                                            <img
                                                src="/placeholder.svg?height=120&width=120"
                                                alt="Thumbnail 4" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="thumb-image">
                                            <img
                                                src="/placeholder.svg?height=120&width=120"
                                                alt="Thumbnail 5" />
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <h1 class="product-title"><?= $productDetail["title"] ?></h1>

                        <div class="product-meta">
                            <div class="product-sku">Mã sản phẩm: <span><?= $productDetail["sku"] ?></span></div>
                            <div class="product-availability <?= $productDetail["isActive"] ?>">
                                <i class="fas fa-check-circle"></i> <?= formatProductStatus($productDetail["isActive"]) ?>
                            </div>
                        </div>
                        <?php
                        $trung_binh = $averageRating['trung_binh'] ?? 0;
                        $tong_danh_gia = $averageRating['tong'] ?? 0;
                        $nguyen = floor($trung_binh);
                        $le = $trung_binh - $nguyen;
                        ?>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $nguyen): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($le >= 0.25 && $le <= 0.75 && $i == $nguyen + 1): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="rating-count">
                                <a href="#reviews-tab" onclick="handleClickOpenReview()"><?= $tong_danh_gia ?> đánh giá</a>
                            </div>
                        </div>

                        <div class="product-price">
                            <?php if (isset($variantId)) : ?>
                                <p class="current-price">
                                    <strong>Giá:</strong>
                                    <span id="variant-price">--</span>
                                </p>
                            <?php else: ?>
                                <p class="current-price">
                                    <strong>Giá:</strong>
                                    <span class="current-price">
                                        <?= formatCurrency($productDetail["priceDefault"], 'vn') ?>
                                    </span>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="product-short-description">
                            <!-- <p>Giày tây nam Arrowwai Classic được làm từ da bò thật 100%, thiết kế thanh lịch, phù hợp với trang phục công sở và các sự kiện trang trọng. Đường may tỉ mỉ, đế cao su chống trượt, mang lại sự thoải mái khi di chuyển.</p> -->
                        </div>
                        <!-- Chọn thuộc tính Color -->
                        <?php
                        // Gom thuộc tính để hiển thị radio
                        $attributesGrouped = [];
                        foreach ($variantAttributes as $variantId => $attrs) {
                            foreach ($attrs as $attr) {
                                $attributesGrouped[$attr['attributeName']][$attr['valueId']] = $attr['attributeValue'];
                            }
                        }
                        ?>

                        <?php if (!empty($attributesGrouped['Color'])): ?>
                            <div class="product-colors">
                                <h3>Màu sắc:</h3>
                                <?php foreach ($attributesGrouped['Color'] as $valueId => $colorName): ?>
                                    <?php
                                    $colorMap = [
                                        'đen' => '#000',
                                        'nâu' => '#5d4037',
                                        'trắng' => '#fff',
                                        'đỏ' => '#f00',
                                        'xanh' => '#2196f3',
                                        'tím' => '#720fe4ff',
                                        'vàng' => '#eddd29ff'
                                    ];
                                    $colorHex = $colorMap[strtolower($colorName)] ?? '#ccc';
                                    ?>
                                    <label class="color-option">
                                        <input type="radio" name="color" value="<?= $valueId ?>">
                                        <span class="color-swatch" style="background-color: <?= $colorHex ?>;"
                                            data-color-name="<?= $colorName ?>"></span>
                                    </label>
                                <?php endforeach; ?>
                                <div>Đã chọn: <span id="selectedColor">---</span></div>
                            </div>
                        <?php endif; ?>

                        <!-- Chọn thuộc tính Size -->
                        <?php if (!empty($attributesGrouped['Size'])): ?>
                            <div class="product-sizes">
                                <h3>Kích cỡ:</h3>
                                <?php foreach ($attributesGrouped['Size'] as $valueId => $size): ?>
                                    <label class="size-option">
                                        <input type="radio" name="size" value="<?= $valueId ?>">
                                        <span class="size-box"><?= $size ?></span>
                                    </label>
                                <?php endforeach; ?>
                                <div>Đã chọn: <span id="selectedSize">---</span></div>
                            </div>
                        <?php endif; ?>

                        <div id="variant-info" style="margin-top: 10px;">
                            <p><strong>Tồn kho:</strong> <span id="variant-stock">--</span></p>
                        </div>


                        <form action="?action=add_to_cart" method="POST" id="addCartForm">
                            <input type="hidden" name="productId" value="<?= $productDetail['id'] ?>">
                            <input type="hidden" name="variantId" id="variantId">
                            <input type="hidden" name="price" id="variantPriceInput">

                            <div class="product-quantity">
                                <h3 class="option-title">Số lượng:</h3>
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn minus" id="quantityMinus">-</button>
                                    <input type="number" name="quantity" id="quantityInput" value="1" min="1" class="quantity-input">
                                    <button type="button" class="quantity-btn plus" id="quantityPlus">+</button>
                                </div>
                            </div>

                            <div class="product-actions">
                                <button class="add-to-cart-btn" type="submit" id="btnAddCart">
                                    <i class="fas fa-shopping-bag"></i> Thêm vào giỏ hàng
                                </button>

                                <button type="button" class="buy-now-btn" id="buyNowBtn"
                                    onclick="window.location.href='<?= htmlspecialchars(BASE_URL . '?action=create_order&id=' . $productDetail['id']) ?>'">
                                    Mua ngay
                                </button>


                                <button type="button" class="wishlist-btn" id="wishlistBtn">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </form>



                        <div class="product-guarantee">
                            <div class="guarantee-item">
                                <div class="guarantee-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="guarantee-content">
                                    <h4>Bảo hành 12 tháng</h4>
                                    <p>Đổi mới trong 30 ngày đầu tiên</p>
                                </div>
                            </div>
                            <div class="guarantee-item">
                                <div class="guarantee-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="guarantee-content">
                                    <h4>Giao hàng toàn quốc</h4>
                                    <p>Miễn phí với đơn hàng trên 1 triệu</p>
                                </div>
                            </div>
                            <div class="guarantee-item">
                                <div class="guarantee-icon">
                                    <i class="fas fa-undo"></i>
                                </div>
                                <div class="guarantee-content">
                                    <h4>Đổi trả dễ dàng</h4>
                                    <p>Trong vòng 7 ngày nếu lỗi nhà sản xuất</p>
                                </div>
                            </div>
                        </div>

                        <div class="product-share">
                            <span class="share-label">Chia sẻ:</span>
                            <div class="share-buttons">
                                <a href="#" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-btn pinterest">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="#" class="share-btn email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Tabs -->
                <div class="product-tabs">
                    <div class="tabs-header">
                        <button class="tab-btn active" data-tab="description">Mô tả sản phẩm</button>
                        <button class="tab-btn" data-tab="reviews" id="reviews-tab">
                            Đánh giá <?= isset($productDetail['averageRating']) && $productDetail['averageRating'] > 0 ? '(' . $productDetail['ratingCount'] . ')' : '' ?>
                        </button>
                        <button class="tab-btn" data-tab="shipping">Vận chuyển & Đổi trả</button>
                    </div>

                    <div class="tabs-content">
                        <!-- Description Tab -->
                        <div class="tab-pane active" id="description">
                            <div class="tab-content-inner">
                                <p><?= nl2br($productDetail['description']) ?></p>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane" id="reviews">
                            <div class="tab-content-inner">
                                <div class="reviews-summary">
                                    <div class="reviews-average">
                                        <div class="average-rating"><?= round($productDetail['averageRating'], 1) ?></div>
                                        <div class="rating-stars">
                                            <?php
                                            $fullStars = floor($productDetail['averageRating']);
                                            $halfStar = $productDetail['averageRating'] - $fullStars >= 0.5;
                                            for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                                            if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                                            for ($i = $fullStars + $halfStar; $i < 5; $i++) echo '<i class="far fa-star"></i>';
                                            ?>
                                        </div>
                                        <div class="total-reviews">Dựa trên <?= $productDetail['ratingCount'] ?> đánh giá</div>
                                    </div>

                                    <div class="reviews-breakdown">
                                        <?php
                                        $tong = $productDetail['ratingCount'] > 0 ? $productDetail['ratingCount'] : 1;
                                        // for ($i = 5; $i >= 1; $i--) {
                                        //     $count = 0;
                                        //     foreach ($ratingStats as $r) {
                                        //         if ($r['star'] == $i) {
                                        //             $count = $r['quantity'];
                                        //             break;
                                        //         }
                                        //     }
                                        //     $percent = round(($count / $tong) * 100);
                                        //     echo "
                                        //     <div class='rating-bar'>
                                        //         <div class='rating-label'>{$i} sao</div>
                                        //         <div class='rating-progress'><div class='progress-bar' style='width: {$percent}%;'></div></div>
                                        //         <div class='rating-count'>{$count}</div>
                                        //     </div>";
                                        // }
                                        ?>
                                    </div>
                                </div>

                                <div class="reviews-list">
                                    <?php if ($comments) : ?>
                                        <?php foreach ($comments as $comment): ?>
                                            <?php if (!$comment['parentId']): ?>
                                                <div class="review-item">
                                                    <div class="review-header">
                                                        <div class="reviewer-info">
                                                            <div class="reviewer-avatar">
                                                                <img src="./assets/uploads/user/<?= $comment['thumbnail'] ?>" width="50" height="50" alt="<?= htmlspecialchars($comment['fullname']) ?>">
                                                            </div>
                                                            <div class="reviewer-details">
                                                                <div class="reviewer-name"><?= htmlspecialchars($comment['fullname']) ?></div>
                                                                <div class="review-date" data-date="<?= htmlspecialchars($comment['createdAt']) ?>"></div>

                                                            </div>
                                                        </div>
                                                        <div class="review-rating">
                                                            <?php
                                                            for ($i = 0; $i < $comment['rating']; $i++) echo '<i class="fas fa-star"></i>';
                                                            for ($i = $comment['rating']; $i < 5; $i++) echo '<i class="far fa-star"></i>';
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="review-content">
                                                        <p class="review-text"><?= htmlspecialchars($comment['content']) ?></p>
                                                    </div>
                                                </div>

                                                <?php foreach ($comments as $reply): ?>
                                                    <?php if ($reply['parentId'] == $comment['id']): ?>
                                                        <div class="reply border rounded p-2 ms-4 bg-white">
                                                            <p><strong><?= htmlspecialchars($reply['fullname']) ?></strong> - <?= $reply['createdAt'] ?></p>
                                                            <p><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p style="text-align: center;">Không có bình luận nào.</p>
                                    <?php endif; ?>
                                </div>


                                <div class="reviews-pagination">
                                    <?php if ($page > 1): ?>
                                        <a class="pagination-btn prev"
                                            href="?action=product_detail&slug=<?= urlencode($productDetail['slug']) ?>&cmt_page=<?= $page - 1 ?>">
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
                                            <a href="?action=product_detail&slug=<?= urlencode($productDetail['slug']) ?>&cmt_page=1"
                                                class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>

                                            <!-- Dấu ... phía trước -->
                                            <?php if ($page > 4): ?>
                                                <span class="pagination-ellipsis">...</span>
                                            <?php endif; ?>

                                            <!-- Các trang ở giữa -->
                                            <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                                                <a href="?action=product_detail&slug=<?= urlencode($productDetail['slug']) ?>&cmt_page=<?= $i ?>"
                                                    class="pagination-number <?= ($page == $i) ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            <?php endfor; ?>

                                            <!-- Dấu ... phía sau -->
                                            <?php if ($page < $totalPages - 3): ?>
                                                <span class="pagination-ellipsis">...</span>
                                            <?php endif; ?>

                                            <!-- Trang cuối -->
                                            <a href="?action=product_detail&slug=<?= urlencode($productDetail['slug']) ?>&cmt_page=<?= $totalPages ?>"
                                                class="pagination-number <?= ($page == $totalPages) ? 'active' : '' ?>">
                                                <?= $totalPages ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($page < $totalPages): ?>
                                        <a class="pagination-btn next"
                                            href="?action=product_detail&slug=<?= urlencode($productDetail['slug']) ?>&cmt_page=<?= $page + 1 ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="pagination-btn next" disabled>
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>



                                <?php if (isset($_SESSION['user'])): ?>
                                    <!-- Hiển thị form đánh giá nếu đã đăng nhập -->
                                    <div class="write-review">
                                        <h3>Viết đánh giá của bạn</h3>
                                        <form class="review-form" method="POST" action="?action=add_comment">
                                            <div class="form-group">
                                                <label>Đánh giá của bạn:</label>
                                                <div class="rating-select" data-selected="0">
                                                    <i class="far fa-star" data-rating="1"></i>
                                                    <i class="far fa-star" data-rating="2"></i>
                                                    <i class="far fa-star" data-rating="3"></i>
                                                    <i class="far fa-star" data-rating="4"></i>
                                                    <i class="far fa-star" data-rating="5"></i>
                                                    <input type="hidden" name="rating" id="ratingInput" value="0">
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="productId" value="<?= $productDetail['id'] ?>">
                                                <input type="hidden" name="slug" value="<?= $productDetail['slug'] ?>">
                                                <label for="reviewContent">Nội dung:</label>
                                                <textarea name="content" id="reviewContent" rows="5" placeholder="Chia sẻ trải nghiệm của bạn với sản phẩm này"></textarea>
                                            </div>
                                            <button type="submit" name="submit-review-btn" class="submit-review-btn">Gửi đánh giá</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <!-- Nếu chưa đăng nhập -->
                                    <p style="text-align:center;">Bạn cần <a href="<?= BASE_URL . '?action=form_signin' ?>" style="color:blue; text-decoration: underline;">đăng nhập</a> để viết đánh giá.</p>
                                <?php endif; ?>



                            </div>
                        </div>



                        <!-- Shipping Tab -->
                        <div class="tab-pane" id="shipping">
                            <div class="tab-content-inner">
                                <h3>Chính sách vận chuyển</h3>
                                <div class="shipping-info">
                                    <div class="info-item">
                                        <h4><i class="fas fa-truck"></i> Phương thức vận chuyển</h4>
                                        <p>Arrowwai sử dụng các đơn vị vận chuyển uy tín như Giao Hàng Nhanh, Giao Hàng Tiết Kiệm, Viettel Post để đảm bảo sản phẩm đến tay khách hàng an toàn và nhanh chóng.</p>
                                    </div>

                                    <div class="info-item">
                                        <h4><i class="fas fa-money-bill-wave"></i> Phí vận chuyển</h4>
                                        <ul>
                                            <li>Miễn phí vận chuyển với đơn hàng từ 1.000.000đ trở lên</li>
                                            <li>Đơn hàng dưới 1.000.000đ: Phí vận chuyển từ 30.000đ - 50.000đ tùy khu vực</li>
                                        </ul>
                                    </div>

                                    <div class="info-item">
                                        <h4><i class="fas fa-clock"></i> Thời gian giao hàng</h4>
                                        <ul>
                                            <li>Nội thành Hà Nội và TP. Hồ Chí Minh: 1-2 ngày làm việc</li>
                                            <li>Các tỉnh thành khác: 2-5 ngày làm việc</li>
                                            <li>Vùng sâu, vùng xa: 5-7 ngày làm việc</li>
                                        </ul>
                                    </div>
                                </div>

                                <h3>Chính sách đổi trả</h3>
                                <div class="return-info">
                                    <div class="info-item">
                                        <h4><i class="fas fa-exchange-alt"></i> Điều kiện đổi trả</h4>
                                        <ul>
                                            <li>Sản phẩm còn nguyên tem, nhãn, hộp đóng gói</li>
                                            <li>Sản phẩm chưa qua sử dụng, còn mới 100%</li>
                                            <li>Có hóa đơn mua hàng hoặc phiếu bảo hành</li>
                                        </ul>
                                    </div>

                                    <div class="info-item">
                                        <h4><i class="fas fa-calendar-alt"></i> Thời hạn đổi trả</h4>
                                        <ul>
                                            <li>Đổi size/màu: trong vòng 7 ngày kể từ ngày nhận hàng</li>
                                            <li>Đổi sản phẩm lỗi do nhà sản xuất: trong vòng 30 ngày kể từ ngày nhận hàng</li>
                                            <li>Bảo hành sản phẩm: 12 tháng kể từ ngày mua hàng</li>
                                        </ul>
                                    </div>

                                    <div class="info-item">
                                        <h4><i class="fas fa-info-circle"></i> Quy trình đổi trả</h4>
                                        <ol>
                                            <li>Liên hệ với Arrowwai qua hotline 1900 4510 hoặc email cskh@Arrowwai.com để được hướng dẫn</li>
                                            <li>Đóng gói sản phẩm cần đổi trả kèm hóa đơn/phiếu bảo hành</li>
                                            <li>Gửi sản phẩm về địa chỉ của Arrowwai theo hướng dẫn</li>
                                            <li>Arrowwai sẽ kiểm tra và xử lý yêu cầu trong vòng 3-5 ngày làm việc</li>
                                            <li>Khách hàng nhận sản phẩm mới hoặc hoàn tiền (tùy trường hợp)</li>
                                        </ol>
                                    </div>

                                    <div class="info-item">
                                        <h4><i class="fas fa-exclamation-triangle"></i> Trường hợp không áp dụng đổi trả</h4>
                                        <ul>
                                            <li>Sản phẩm đã qua sử dụng, có dấu hiệu hư hỏng do người dùng</li>
                                            <li>Sản phẩm không còn nguyên vẹn tem, nhãn, hộp đóng gói</li>
                                            <li>Sản phẩm thuộc chương trình khuyến mãi, giảm giá đặc biệt (trừ trường hợp lỗi nhà sản xuất)</li>
                                            <li>Quá thời hạn đổi trả quy định</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="related-products">
                    <h2 class="section-title">Sản phẩm liên quan</h2>
                    <div class="products-slider">
                        <div class="swiper related-products-swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($relatedProducts as $related): ?>
                                    <div class="swiper-slide">

                                        <div class="product-card">
                                            <div class="product-image">
                                                <a href="?action=product_detail&slug=<?= $related['slug'] ?>">
                                                    <img src="<?= BASE_ASSETS_UPLOADS . $related['thumbnail'] ?>" alt="<?= $related['title'] ?>" width="300">
                                                </a>
                                                <div class="product-actions">
                                                    <button class="quick-view-btn" title="Xem nhanh">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="add-to-wishlist-btn" title="Thêm vào yêu thích">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                    <button class="add-to-cart-btn" title="Thêm vào giỏ hàng">
                                                        <i class="fas fa-shopping-bag"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h3 class="product-title">
                                                    <a href="index.php?router=product-detail&id=<?= $related['id'] ?>"><?= $related['title'] ?></a>
                                                </h3>
                                                <div class="product-price">
                                                    <span class="current-price"><?= formatCurrency($related['priceDefault'], 'vn') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once("./client/views/layout/site/footer-site/footer-site.php") ?>

    <script src="./client/views/layout/site/layout-site.js"></script>

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

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const galleryMain = new Swiper('.gallery-main-swiper', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

            // Related Products Swiper
            const relatedProductsSwiper = new Swiper('.related-products-swiper', {
                spaceBetween: 20,
                slidesPerView: 4,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    }
                }
            });

            // Recently Viewed Products Swiper
            const recentlyViewedSwiper = new Swiper('.recently-viewed-swiper', {
                spaceBetween: 20,
                slidesPerView: 4,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    }
                }
            });

            // Product Tabs
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons and panes
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Show corresponding tab pane
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            function handleClickOpenReview() {
                const tabReview = document.getElementById('reviews-tab');

                // Remove active class from all buttons and panes
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                tabReview.classList.add('active');

                // Show corresponding tab pane
                const tabId = tabReview.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            }

            // Đảm bảo hàm này load sau DOM
            window.handleClickOpenReview = handleClickOpenReview;

            moment.locale('vi'); // Bật tiếng Việt

            const reviewDates = document.querySelectorAll('.review-date');
            reviewDates.forEach(el => {
                const rawDate = el.getAttribute('data-date');
                const formatted = moment(rawDate).fromNow(); // VD: "3 ngày trước"
                el.textContent = formatted;
            });

            // Buy Now Button
            const buyNowBtn = document.getElementById('buyNowBtn');

            buyNowBtn.addEventListener('click', function() {
                // Get selected options
                const selectedColor = document.querySelector('.color-option input[name="color"]:checked').value;
                const selectedSize = document.querySelector('.size-option input[name="size"]:checked').value;
                const quantity = document.getElementById('quantityInput').value;

                // Show confirmation message
                alert(`Chuyển đến trang thanh toán!\nSản phẩm: Giày tây nam Arrowwai Classic\nMàu sắc: ${selectedColor === 'black' ? 'Đen' : 'Nâu'}\nKích cỡ: ${selectedSize}\nSố lượng: ${quantity}`);

            });

            const ratingStars = document.querySelectorAll('.rating-select i');
            const ratingContainer = document.querySelector('.rating-select');
            const ratingInput = document.getElementById('ratingInput');

            ratingStars.forEach((star, index) => {
                const ratingValue = index + 1;

                star.addEventListener('mouseover', () => {
                    highlightStars(ratingValue);
                });

                star.addEventListener('mouseout', () => {
                    const selectedRating = parseInt(ratingContainer.getAttribute('data-selected')) || 0;
                    highlightStars(selectedRating);
                });

                star.addEventListener('click', () => {
                    ratingContainer.setAttribute('data-selected', ratingValue);
                    ratingInput.value = ratingValue;
                    highlightStars(ratingValue);
                });
            });

            function highlightStars(rating) {
                ratingStars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas');
                    } else {
                        star.classList.remove('fas');
                        star.classList.add('far');
                    }
                });
            }
        });


        const variantsData = <?= json_encode($variants) ?>;
        const variantAttributes = <?= json_encode($variantAttributes) ?>;

        let selectedColor = null;
        let selectedSize = null;

        // Lưu giá mặc định từ PHP để hiển thị ban đầu
        const defaultPrice = "<?= formatCurrency($productDetail["priceDefault"], 'vn') ?>";
        document.getElementById('variant-price').textContent = defaultPrice;

        // Bắt sự kiện chọn màu
        document.querySelectorAll('input[name="color"]').forEach(input => {
            input.addEventListener('change', (e) => {
                selectedColor = parseInt(e.target.value);
                const name = e.target.closest('label').querySelector('.color-swatch').dataset.colorName;
                document.getElementById('selectedColor').textContent = name;
                updateVariantInfo();
            });
        });

        // Bắt sự kiện chọn size
        document.querySelectorAll('input[name="size"]').forEach(input => {
            input.addEventListener('change', (e) => {
                selectedSize = parseInt(e.target.value);
                const size = e.target.closest('label').querySelector('.size-box').textContent;
                document.getElementById('selectedSize').textContent = size;
                updateVariantInfo();
            });
        });

        function updateVariantInfo() {
            if (!selectedColor || !selectedSize) return;

            let matched = false;

            for (const variant of variantsData) {
                const attrValues = (variantAttributes[variant.id] || []).map(a => parseInt(a.valueId));
                if (attrValues.includes(selectedColor) && attrValues.includes(selectedSize)) {

                    document.getElementById('variant-price').textContent =
                        Number(variant.price).toLocaleString() + 'đ';

                    document.getElementById('variant-stock').textContent =
                        variant.stock > 0 ? variant.stock : 'Hết hàng';

                    document.getElementById('variantId').value = variant.id;
                    document.getElementById('variantPriceInput').value = variant.price;

                    // Lưu trạng thái vào attribute
                    document.getElementById('btnAddCart').setAttribute('data-out-of-stock', variant.stock <= 0);

                    matched = true;
                    break;
                }
            }

            if (!matched) {
                document.getElementById('variant-price').textContent = defaultPrice;
                document.getElementById('variant-stock').textContent = '--';
                document.getElementById('variantId').value = '';
                document.getElementById('variantPriceInput').value = '';
                document.getElementById('btnAddCart').setAttribute('data-out-of-stock', true);
            }
        }

        document.getElementById('btnAddCart').addEventListener('click', function(e) {
            const outOfStock = this.getAttribute('data-out-of-stock') === 'true';
            if (outOfStock) {
                e.preventDefault();
                alert('Sản phẩm đã hết hàng!');
                return false;
            }
        });

        // Kiểm tra khi ấn Mua ngay
        document.getElementById('buyNowBtn').addEventListener('click', function(e) {
            const stockText = document.getElementById('variant-stock').textContent;
            const stock = parseInt(stockText) || 0;

            if (stock <= 0) {
                e.preventDefault();
                alert('Sản phẩm đã hết hàng!');
                return false;
            }
        });

        // Tăng giảm số lượng
        const quantityMinus = document.getElementById('quantityMinus');
        const quantityPlus = document.getElementById('quantityPlus');
        const quantityInput = document.getElementById('quantityInput');

        quantityMinus.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > 0) {
                quantityInput.value = value - 1;
            }
        });

        quantityPlus.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value < 10) {
                quantityInput.value = value + 1;
            }
        });
    </script>

</body>

</html>