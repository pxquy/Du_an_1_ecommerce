<?php
extract($product);
extract($category);

$_SESSION['redirect-route'] = "index.php?router=product-detail&id=$san_pham_id"
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quí Super Shoes - <?= $ten_san_pham ?></title>
    <link rel="stylesheet" href="./views/layout/site/layout-site.css">
    <link rel="stylesheet" href="./views/layout/site/header-site/header-site.css">
    <link rel="stylesheet" href="./views/layout/site/footer-site/footer-site.css">
    <link rel="stylesheet" href="./views/pages/site/product-detail/product-detail.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

    <!-- SEO -->
    <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Quí Super Shoes" />
    <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />


    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/vi.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php include_once("./views/layout/site/header-site/header-site.php") ?>
    <!-- Main Content - Product Detail Page -->
    <main class="main-content">
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li><a href="index.php?router=home">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><a href="index.php?router=product&category_id=<?= $danh_muc_id ?>"><?= $ten_danh_muc ?></a></li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li><?= $ten_san_pham ?></li>
                </ul>
            </div>
        </div>

        <!-- Product Detail Section -->
        <section class="product-detail-section">
            <div class="container">
                <div class="product-detail-container">
                    <!-- Product Gallery -->
                    <div class="product-gallery">
                        <!-- Main Gallery -->
                        <div class="gallery-main">
                            <div class="swiper gallery-main-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="gallery-image">
                                            <img src="./assets/uploads/product/<?= $hinh ?>" alt="<?= $ten_san_pham ?>" id="zoom-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <h1 class="product-title"><?= $ten_san_pham ?></h1>

                        <div class="product-meta">
                            <div class="product-sku">Mã sản phẩm: <span><?= $ma_san_pham ?></span></div>
                            <div class="product-availability <?= $trang_thai ?>">
                                <i class="fas fa-check-circle"></i> <?= formatProductStatus($trang_thai) ?>
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
                            <span class="current-price"><?= formatCurrency($gia, 'vn') ?></span>
                        </div>

                        <div class="product-short-description">
                            <!-- <p>Giày tây nam Mulgati Classic được làm từ da bò thật 100%, thiết kế thanh lịch, phù hợp với trang phục công sở và các sự kiện trang trọng. Đường may tỉ mỉ, đế cao su chống trượt, mang lại sự thoải mái khi di chuyển.</p> -->
                        </div>

                        <form method="post">
                            <div class="product-quantity">
                                <h3 class="option-title">Số lượng:</h3>
                                <div class="quantity-selector">
                                    <div class="quantity-btn minus" id="quantityMinus">-</div>
                                    <input type="number" name="quantity" id="quantityInput" class="quantity-input" value="1" min="1" max="10">
                                    <div class="quantity-btn plus" id="quantityPlus">+</div>
                                </div>
                            </div>

                            <div class="product-actions">
                                <button class="add-to-cart-btn" id="addToCartBtn" name="submit-add-to-cart-btn">
                                    <i class="fas fa-shopping-bag"></i> Thêm vào giỏ hàng
                                </button>
                                <button class="buy-now-btn" id="buyNowBtn" name="submit-buy-now-btn"><a href="index.php?router=checkout&id=<?= $san_pham_id ?>">Mua ngay</a></button>
                                <button class="wishlist-btn" id="wishlistBtn">
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
                            Đánh giá <?= isset($averageRating['tong']) && $averageRating['tong'] > 0 ? '(' . $averageRating['tong'] . ')' : '' ?>
                        </button>
                        <button class="tab-btn" data-tab="shipping">Vận chuyển & Đổi trả</button>
                    </div>

                    <div class="tabs-content">
                        <!-- Description Tab -->
                        <div class="tab-pane active" id="description">
                            <div class="tab-content-inner">
                                <p><?= nl2br($mo_ta) ?></p>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane" id="reviews">
                            <div class="tab-content-inner">
                                <div class="reviews-summary">
                                    <div class="reviews-average">
                                        <div class="average-rating"><?= round($averageRating['trung_binh'], 1) ?></div>
                                        <div class="rating-stars">
                                            <?php
                                            $fullStars = floor($averageRating['trung_binh']);
                                            $halfStar = $averageRating['trung_binh'] - $fullStars >= 0.5;
                                            for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                                            if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                                            for ($i = $fullStars + $halfStar; $i < 5; $i++) echo '<i class="far fa-star"></i>';
                                            ?>
                                        </div>
                                        <div class="total-reviews">Dựa trên <?= $averageRating['tong'] ?> đánh giá</div>
                                    </div>

                                    <div class="reviews-breakdown">
                                        <?php
                                        $tong = $averageRating['tong'] > 0 ? $averageRating['tong'] : 1;
                                        for ($i = 5; $i >= 1; $i--) {
                                            $count = 0;
                                            foreach ($ratingStats as $r) {
                                                if ($r['sao'] == $i) {
                                                    $count = $r['so_luong'];
                                                    break;
                                                }
                                            }
                                            $percent = round(($count / $tong) * 100);
                                            echo "
                                            <div class='rating-bar'>
                                                <div class='rating-label'>{$i} sao</div>
                                                <div class='rating-progress'><div class='progress-bar' style='width: {$percent}%;'></div></div>
                                                <div class='rating-count'>{$count}</div>
                                            </div>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="reviews-list">
                                    <?php if ($comments) : ?>
                                        <?php foreach ($comments as $comment): ?>
                                            <div class="review-item">
                                                <div class="review-header">
                                                    <div class="reviewer-info">
                                                        <div class="reviewer-avatar">
                                                            <img src="./assets/uploads/user/<?= $comment['hinh'] ?>" width="50" height="50" alt="<?= htmlspecialchars($comment['ho_va_ten']) ?>">
                                                        </div>
                                                        <div class="reviewer-details">
                                                            <div class="reviewer-name"><?= htmlspecialchars($comment['ho_va_ten']) ?></div>
                                                            <div class="review-date" data-date="<?= htmlspecialchars($comment['ngay_binh_luan']) ?>"></div>

                                                        </div>
                                                    </div>
                                                    <div class="review-rating">
                                                        <?php
                                                        for ($i = 0; $i < $comment['sao']; $i++) echo '<i class="fas fa-star"></i>';
                                                        for ($i = $comment['sao']; $i < 5; $i++) echo '<i class="far fa-star"></i>';
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="review-content">
                                                    <p class="review-text"><?= htmlspecialchars($comment['noi_dung']) ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p style="text-align: center;">Không có bình luận nào.</p>
                                    <?php endif; ?>
                                </div>


                                <div class="reviews-pagination">
                                    <?php if ($page > 1): ?>
                                        <a class="pagination-btn prev" href="?router=product-detail&id=<?= $product_id ?>&page=<?= $page - 1 ?>"><i class="fas fa-chevron-left"></i></a>
                                    <?php else: ?>
                                        <button class="pagination-btn prev" disabled><i class="fas fa-chevron-left"></i></button>
                                    <?php endif; ?>

                                    <div class="pagination-numbers">
                                        <?php if ($totalPages > 1): ?>
                                            <a href="?router=product-detail&id=<?= $product_id ?>&page=1"
                                                class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>

                                            <?php if ($page > 4): ?>
                                                <span class="pagination-ellipsis">...</span>
                                            <?php endif; ?>

                                            <?php for ($i = max(2, $page - 2); $i <= min($totalPages - 1, $page + 2); $i++): ?>
                                                <a href="?router=product-detail&id=<?= $product_id ?>&page=<?= $i ?>"
                                                    class="pagination-number <?= ($page == $i) ? 'active' : '' ?>">
                                                    <?= $i ?>
                                                </a>
                                            <?php endfor; ?>

                                            <?php if ($page < $totalPages - 3): ?>
                                                <span class="pagination-ellipsis">...</span>
                                            <?php endif; ?>

                                            <a href="?router=product-detail&id=<?= $product_id ?>&page=<?= $totalPages ?>"
                                                class="pagination-number <?= ($page == $totalPages) ? 'active' : '' ?>">
                                                <?= $totalPages ?>
                                            </a>
                                        <?php else: ?>
                                            <a href="?router=product-detail&id=<?= $product_id ?>&page=1"
                                                class="pagination-number <?= ($page == 1) ? 'active' : '' ?>">1</a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($page < $totalPages): ?>
                                        <a class="pagination-btn next" href="?router=product-detail&id=<?= $product_id ?>&page=<?= $page + 1 ?>"><i class="fas fa-chevron-right"></i></a>
                                    <?php else: ?>
                                        <button class="pagination-btn next" disabled><i class="fas fa-chevron-right"></i></button>
                                    <?php endif; ?>
                                </div>


                                <?php if (isset($_SESSION['user'])): ?>
                                    <!-- Hiển thị form đánh giá nếu đã đăng nhập -->
                                    <div class="write-review">
                                        <h3>Viết đánh giá của bạn</h3>
                                        <form class="review-form" method="POST" action="">
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
                                                <label for="reviewContent">Nội dung:</label>
                                                <textarea name="reviewContent" id="reviewContent" rows="5" placeholder="Chia sẻ trải nghiệm của bạn với sản phẩm này"></textarea>
                                            </div>
                                            <button type="submit" name="submit-review-btn" class="submit-review-btn">Gửi đánh giá</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <!-- Nếu chưa đăng nhập -->
                                    <p style="text-align:center;">Bạn cần <a href="index.php?router=login" style="color:blue; text-decoration: underline;">đăng nhập</a> để viết đánh giá.</p>
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
                                        <p>Mulgati sử dụng các đơn vị vận chuyển uy tín như Giao Hàng Nhanh, Giao Hàng Tiết Kiệm, Viettel Post để đảm bảo sản phẩm đến tay khách hàng an toàn và nhanh chóng.</p>
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
                                            <li>Liên hệ với Mulgati qua hotline 1900 4510 hoặc email cskh@mulgati.com để được hướng dẫn</li>
                                            <li>Đóng gói sản phẩm cần đổi trả kèm hóa đơn/phiếu bảo hành</li>
                                            <li>Gửi sản phẩm về địa chỉ của Mulgati theo hướng dẫn</li>
                                            <li>Mulgati sẽ kiểm tra và xử lý yêu cầu trong vòng 3-5 ngày làm việc</li>
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
                                <?php foreach ($productRelated as $related): ?>
                                    <div class="swiper-slide">
                                        <div class="product-card">
                                            <div class="product-image">
                                                <a href="index.php?router=product-detail&id=<?= $related['san_pham_id'] ?>">
                                                    <img src="./assets/uploads/product/<?= $related['hinh'] ?>" alt="<?= $related['ten_san_pham'] ?>" width="300">
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
                                                    <a href="index.php?router=product-detail&id=<?= $related['san_pham_id'] ?>"><?= $related['ten_san_pham'] ?></a>
                                                </h3>
                                                <div class="product-price">
                                                    <span class="current-price"><?= formatCurrency($related['gia'], 'vn') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once("./views/layout/site/footer-site/footer-site.php") ?>

    <script src="./views/layout/site/layout-site.js"></script>

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
        document.addEventListener('DOMContentLoaded', function() {

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

            // Quantity Selector
            const quantityMinus = document.getElementById('quantityMinus');
            const quantityPlus = document.getElementById('quantityPlus');
            const quantityInput = document.getElementById('quantityInput');

            quantityMinus.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            quantityPlus.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value < 10) {
                    quantityInput.value = value + 1;
                }
            });

            // Buy Now Button
            const buyNowBtn = document.getElementById('buyNowBtn');

            buyNowBtn.addEventListener('click', function() {
                // Get selected options
                const selectedColor = document.querySelector('.color-option input[name="color"]:checked').value;
                const selectedSize = document.querySelector('.size-option input[name="size"]:checked').value;
                const quantity = document.getElementById('quantityInput').value;

                // Show confirmation message
                alert(`Chuyển đến trang thanh toán!\nSản phẩm: Giày tây nam Mulgati Classic\nMàu sắc: ${selectedColor === 'black' ? 'Đen' : 'Nâu'}\nKích cỡ: ${selectedSize}\nSố lượng: ${quantity}`);

                // In a real implementation, this would redirect to checkout page
                // window.location.href = 'checkout.html';
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
    </script>

</body>

</html>