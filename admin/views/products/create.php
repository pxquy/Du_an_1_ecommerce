<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $key => $value): ?>
                <?php if (is_array($value)): ?>
                    <?php foreach ($value as $sub): ?>
                        <li><?= htmlspecialchars($sub) ?></li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li><?= htmlspecialchars($value) ?></li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>


<form action="<?= BASE_URL_ADMIN . '&action=products-store' ?>" method="post" enctype="multipart/form-data">
    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">Thông tin cơ bản</h5>
        <div class="mb-3 mt-3 row">
            <div class="col">
                <label for="title" class="form-label">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="col">
                <label for="sku" class="form-label">Mã sản phẩm:</label>
                <input type="text" class="form-control" id="sku" name="sku">
            </div>

        </div>
        <div class="mb-3 mt-3">
            <label for="shortDescription" class="form-label">Mô tả ngắn:</label>
            <input type="text" class="form-control" id="shortDescription" name="shortDescription">
        </div>
        <div class="mb-3 mt-3">
            <label for="description" class="form-label">Mô tả dài:</label>
            <textarea class="h-32 w-full border border-gray-300 p-2 rounded form-control" id="description"
                name="description" placeholder="Nhập mô tả"></textarea>
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">Chi tiết sản phẩm</h5>
        <div class="mb-3 mt-3 row">
            <div class="col">
                <label for="priceDefault" class="form-label">Đơn giá:</label>
                <input type="number" class="form-control" id="priceDefault" name="priceDefault" step="0.01" min="0"
                    max="99999999.99">
            </div>
            <div class="col">
                <label for="discount" class="form-label">Giảm giá:</label>
                <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0"
                    max="99999999.99">
            </div>
        </div>

        <div class="mb-3 mt-3">
            <table>
                <tr>
                    <td><label for="categoryId" class="form-label">Danh mục: </label></td>
                    <td class="px-5"><label for="brandId" class="form-label">Thương hiệu </label></td>
                </tr>
                <tr>
                    <td><select name="categoryId" id="categoryId" class="form-select">
                            <?php foreach ($categoryPluck as $id => $title): ?>
                                <option value="<?= $id ?>"><?= $title ?></option>
                            <?php endforeach ?>
                        </select></td>
                    <td class="px-5"><select name="brandId" id="brandId" class="form-select">
                            <?php foreach ($brandPluck as $id => $title): ?>
                                <option value="<?= $id ?>"><?= $title ?></option>
                            <?php endforeach ?>
                        </select></td>
                </tr>
            </table>

            <div class="mb-3 mt-3">
                <label for="isActive" class="form-label">Trạng thái</label>
                <input type="radio" id="disabled" name="isActive" value="0">
                <label for="disabled">Ngừng bán</label>
                <input type="radio" id="active" name="isActive" value="1" checked>
                <label for="active">Đang bán</label>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">SEO sản phẩm</h5>
        <div class="mb-3 mt-3">
            <label for="seoTitle" class="form-label">Seo Title:</label>
            <input type="text" class="form-control" id="seoTitle" name="seoTitle">
        </div>
        <div class="mb-3 mt-3">
            <label for="seoDescription" class="form-label">Seo Description</label>
            <input type="text" class="form-control" id="seoDescription" name="seoDescription">
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <div class="mb-3 mt-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện:</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
            <div id="preview-thumbnail" class="mt-2"></div> <!-- vùng preview -->
        </div>

        <div class="mb-3 mt-3">
            <label for="images" class="form-label">Ảnh khác:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
            <div id="preview-images" class="mt-2 flex flex-wrap gap-2"></div> <!-- vùng preview -->
        </div>
    </div>

    <div class="d-flex flex-row-reverse gap-3 mt-3">
        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        <a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="btn btn-secondary">Quay Lại</a>
    </div>
</form>

<script>
    // Hiển thị ảnh đại diện
    document.getElementById('thumbnail').addEventListener('change', function (e) {
        const preview = document.getElementById('preview-thumbnail');
        preview.innerHTML = ''; // Xoá ảnh cũ

        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = "h-32 rounded border";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Hiển thị nhiều ảnh khác
    document.getElementById('images').addEventListener('change', function (e) {
        const preview = document.getElementById('preview-images');
        preview.innerHTML = ''; // Xoá ảnh cũ

        Array.from(e.target.files).forEach(file => {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.className = "h-32 object-cover rounded border";
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>