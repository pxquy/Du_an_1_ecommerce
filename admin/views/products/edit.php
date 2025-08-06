<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<?php
if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $value): ?>
                <li><?= $value ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=products-update&id=' . $product['id'] ?>" method="post"
    enctype="multipart/form-data">
    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">Thông tin cơ bản</h5>
        <div class="mb-3 mt-3">
            <label for="title" class="form-label">Tên sản phẩm:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $product['title'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="shortDescription" class="form-label">Mô tả ngắn:</label>
            <input type="text" class="form-control" id="shortDescription" name="shortDescription"
                value="<?= $product['shortDescription'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="description" class="form-label">Mô tả dài:</label>
            <textarea class="h-32 w-full border border-gray-300 p-2 rounded form-control" id="description"
                name="description" placeholder="Nhập mô tả"><?= $product['description'] ?></textarea>
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">Chi tiết sản phẩm</h5>
        <div class="mb-3 mt-3 row">
            <div class="col">
                <label for="priceDefault" class="form-label">Đơn giá:</label>
                <input type="number" class="form-control" id="priceDefault" name="priceDefault" step="0.01" min="0"
                    max="99999999.99" value="<?= $product['priceDefault'] ?>">
            </div>
            <div class="col">
                <label for="discount" class="form-label">Giảm giá:</label>
                <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0"
                    max="99999999.99" value="<?= $product['discount'] ?>">
            </div>
        </div>

        <div class="mb-3 mt-3">
            <table>
                <tr>
                    <td><label for="categoryId" class="form-label">Danh mục: </label></td>
                    <td class="px-5"><label for="brandId" class="form-label">Thương hiệu </label></td>
                </tr>
                <tr>
                    <td><select name="categoryId" id="categoryId" class="form-control">
                            <?php foreach ($categoryPluck as $id => $title): ?>
                                <option value="<?= $id ?>" <?= $product['categoryId'] == $id ? 'selected' : '' ?>><?= $title ?>
                                </option>
                            <?php endforeach ?>
                        </select></td>
                    <td class="px-5"><select name="brandId" id="brandId" class="form-control">
                            <?php foreach ($brandPluck as $id => $title): ?>
                                <option value="<?= $id ?>" <?= $product['brandId'] == $id ? 'selected' : '' ?>><?= $title ?>
                                </option>
                            <?php endforeach ?>
                        </select></td>
                </tr>
            </table>

            <div class="mb-3 mt-3">
                <label for="isActive" class="form-label">Trạng thái</label>
                <input type="radio" id="disabled" name="isActive" value="0" <?= $product['isActive'] == 0 ? 'checked' : '' ?>>
                <label for="disabled">Ngừng bán</label>
                <input type="radio" id="active" name="isActive" value="1" <?= $product['isActive'] == 1 ? 'checked' : '' ?>>
                <label for="active">Đang bán</label>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">SEO sản phẩm</h5>
        <div class="mb-3 mt-3">
            <label for="seoTitle" class="form-label">Seo Title:</label>
            <input type="text" class="form-control" id="seoTitle" name="seoTitle" value="<?= $product['seoTitle'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="seoDescription" class="form-label">Seo Description</label>
            <input type="text" class="form-control" id="seoDescription" name="seoDescription"
                value="<?= $product['seoDescription'] ?>">
        </div>
    </div>

    <div class="bg-white p-4 rounded mt-3">
        <h5 class="mb-3 mt-3">Chỉnh sửa hình ảnh</h5>

        <div class="mb-3 mt-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện:</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
            <div id="preview-thumbnail" class="mt-2">
                <?php if (!empty($product['thumbnail'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . 'products/' . $product['thumbnail'] ?>"
                        class="h-32 rounded border" />
                <?php endif ?>
            </div>
        </div>

        <div class="mb-3 mt-3">
            <label for="images" class="form-label">Ảnh khác:</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
            <div id="preview-images" class="mt-2 flex flex-wrap gap-2">
                <?php if (!empty($product['images'])):
                    $images = json_decode($product['images'], true);
                    if (is_array($images)):
                        foreach ($images as $img): ?>
                            <img src="<?= BASE_ASSETS_UPLOADS . 'products/' . $img ?>" class="h-32 object-cover rounded border" />
                        <?php endforeach;
                    endif;
                endif ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>

<script>
    // Xem trước ảnh đại diện
    document.getElementById('thumbnail')?.addEventListener('change', function (e) {
        const preview = document.getElementById('preview-thumbnail');
        preview.innerHTML = '';

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

    // Xem trước nhiều ảnh khác
    document.getElementById('images')?.addEventListener('change', function (e) {
        const preview = document.getElementById('preview-images');
        preview.innerHTML = '';

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