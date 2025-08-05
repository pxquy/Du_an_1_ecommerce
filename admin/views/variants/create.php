<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    $msg = is_array($_SESSION['msg']) ? implode('<br>', $_SESSION['msg']) : $_SESSION['msg'];
    echo "<div class='alert $class'>$msg</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<form action="<?= BASE_URL_ADMIN . '&action=variants-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 bg-white p-4">
        <div class="row mb-3">
            <div class="col">
                <label for="productId" class="form-label">Sản phẩm:</label>
                <?php if (isset($_GET['productId'])): ?>
                    <input type="hidden" id="productId" name="productId" value="<?= $product['id'] ?>" readonly>
                    <p class="form-control"><?= $product['title'] ?></p>
                <?php else: ?>
                    <select name="productId" id="productId" class="form-select">
                        <option value="">Chọn sản phẩm</option>
                        <?php foreach ($productPluck as $id => $title): ?>
                            <option value="<?= $id ?>">
                                <?= $title ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                <?php endif ?>
            </div>
        </div>
    </div>


    <!-- Bảng thuộc tính - giá trị -->
    <div class="mb-3 bg-white p-4">
        <h5>Thuộc tính của biến thể:</h5>
        <?php foreach ($attributes as $attribute): ?>
            <label class="form-label"><?= $attribute['description'] ?></label>
            <div class="col mb-4 d-flex align-items-center gap-5">
                <?php foreach ($attribute['value'] as $value): ?>
                    <div>
                        <label for="value-<?= $value['id'] ?>"><?= $value['value'] ?></label>
                        <input type="checkbox" id="value-<?= $value['id'] ?>" name="attributes[<?= $attribute['id'] ?>][]"
                            value="<?= $value['id'] ?>">
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    </div>

    <button type="submit" class="btn btn-primary">Tạo biến thể</button>
    <a href="<?= BASE_URL_ADMIN . '&action=variants-index' ?>" class="btn btn-outline-dark">Quay lại</a>
</form>