<div class=" ">
    <div class="row p-4 bg-white rounded shadow-sm mb-4">
        <!-- Cột ảnh -->
        <div class="col-6">
            <div class="text-center mb-4">
                <img id="mainImage" src="<?= BASE_ASSETS_UPLOADS . $productDetail['thumbnail'] ?>" class="img-fluid"
                    alt="Ảnh sản phẩm">
            </div>

            <!-- Các thumbnail -->
            <div class="row">
                <div class="col-3 col-sm-2 mb-3">
                    <img src="<?= BASE_ASSETS_UPLOADS . $productDetail['thumbnail'] ?>"
                        class="img-thumbnail thumb-img active"
                        data-src="<?= BASE_ASSETS_UPLOADS . $productDetail['thumbnail'] ?>" alt="Ảnh chính">
                </div>

                <?php foreach ($productImages as $index => $productImage): ?>
                    <div class="col-3 col-sm-2 mb-3">
                        <img src="<?= BASE_ASSETS_UPLOADS . $productImage['imageUrl'] ?>" class="img-thumbnail thumb-img"
                            data-src="<?= BASE_ASSETS_UPLOADS . $productImage['imageUrl'] ?>"
                            alt="ảnh sản phẩm <?= $index + 1 ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Cột thông tin -->
        <div class="col-6">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <span class="rounded-full font-semibold px-3 py-2 text-s
                    <?= $productDetail['stockTotal'] > 20
                        ? 'bg-success text-white'
                        : ($productDetail['stockTotal'] == 0
                            ? 'bg-danger text-white'
                            : 'bg-warning text-dark') ?>">
                    <?= $productDetail['stockTotal'] > 20 ? 'Còn hàng' : ($productDetail['stockTotal'] == 0 ? 'Hết hàng' : 'Ít hàng') ?>
                </span>
                <span class="ms-2 text-muted">ID: <?= $productDetail['id'] ?></span>
            </div>

            <h2 class="fw-bold mb-2"><?= $productDetail['title'] ?></h2>

            <div class="d-flex align-items-center text-warning mb-3 fs-5">
                <span class="me-2">★★★★★</span>
                <span class="text-dark"><?= $productDetail['averageRating'] ?> (<?= $productDetail['ratingCount'] ?>
                    đánh giá)</span>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <h2 class="fw-bold text-danger mb-0">
                    <?= number_format(($productDetail['priceDefault'] * (100 - $productDetail['discount'])) / 100, 0, ',', '.') ?>₫
                </h2>
                <span class="text-muted text-decoration-line-through">
                    <?= number_format($productDetail['priceDefault'], 0, ',', '.') ?>₫
                </span>
                <span class="badge bg-danger"><?= $productDetail['discount'] ?>% OFF</span>
            </div>

            <div class="w-100 max-w-xl fs-6 text-gray-700">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="fw-semibold">Danh mục:</span>
                    <span><?= $productDetail['categoryTitle'] ?? 'Không có' ?></span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="fw-semibold">Thương hiệu:</span>
                    <span><?= $productDetail['brandTitle'] ?? 'Không có' ?></span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="fw-semibold">Mã sản phẩm:</span>
                    <span><?= $productDetail['sku'] ?? 'AT-WH-001' ?></span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="fw-semibold">Mô tả ngắn:</span>
                    <span><?= $productDetail['shortDescription'] ?? 'Không có' ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-4 bg-white rounded shadow-sm mb-4">
        <h3>Mô tả sản phẩm</h3>
        <div>
            <p><?= $productDetail['description'] ?></p>
        </div>
    </div>
</div>

<h3 class="mt-5 mb-3">📦 Biến thể của sản phẩm</h3>
<a href="<?= BASE_URL_ADMIN . '&action=variants-create&productId=' . $productDetail['id'] ?>"
    class="btn btn-primary mb-3">
    ➕ Thêm mới biến thể
</a>
<a href="<?= BASE_URL_ADMIN . '&action=variants-edit&productId=' . $productDetail['id'] ?>"
    class="btn btn-warning mb-3">
    Sửa biến thể
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <?php foreach (array_keys($productDetail['variants'][0]) as $keys): ?>
                <th><?= ucfirst($keys) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productDetail['variants'] as $variant): ?>
            <tr>
                <?php foreach (array_values($variant) as $value): ?>
                    <td><?= $value ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Nút quay lại -->
<div class="mt-4">
    <a href="<?= BASE_URL_ADMIN . '&action=products-edit&id=' . $productDetail['id'] ?>" class="btn btn-warning">✏️ Sửa
        sản
        phẩm</a>
    <a href="<?= BASE_URL_ADMIN . '&action=products-delete&id=' . $productDetail['id'] ?>"
        onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này?')" class="btn btn-danger">🗑️ Xoá</a>
    <a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="btn btn-secondary">⬅️ Quay lại danh sách</a>
</div>

<!-- CSS thêm để đánh dấu thumbnail đang chọn -->
<style>
    .thumb-img.active {
        border: 2px solid #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        transition: all 0.2s ease;
    }

    .thumb-img {
        cursor: pointer;
    }
</style>

<!-- JS để thay đổi ảnh chính khi click thumbnail -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mainImage = document.getElementById("mainImage");
        const thumbnails = document.querySelectorAll(".thumb-img");

        thumbnails.forEach(img => {
            img.addEventListener("click", function () {
                const newSrc = this.getAttribute("data-src");
                mainImage.setAttribute("src", newSrc);

                thumbnails.forEach(i => i.classList.remove("active"));
                this.classList.add("active");
            });
        });
    });
</script>