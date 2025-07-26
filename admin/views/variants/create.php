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
            <?php foreach ($_SESSION['error'] as $value): ?>
                <li><?= $value ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=variants-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="productId" class="form-label">Sản phẩm:</label>
        <select name="productId" id="productId" class="form-select">
            <?php foreach ($productPluck as $id => $title): ?>
                <option value="<?= $id ?>"><?= $title ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Bảng thuộc tính - giá trị -->
    <h5>Thuộc tính của biến thể:</h5>
    <table class="table table-bordered" id="attributeTable">
        <thead>
            <tr>
                <th>Thuộc tính</th>
                <th>Giá trị</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="attributes[]" class="form-select attr-select">
                        <option value="">-- Chọn --</option>
                        <?php foreach ($attributePluck as $id => $name): ?>
                            <option value="<?= $id ?>"><?= $name ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <select name="values[]" class="form-select value-select">
                        <option value="">-- Chọn giá trị --</option>
                        <!-- Sẽ được cập nhật qua JS -->
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Xoá</button>
                </td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary" id="addRow">➕ Thêm thuộc tính</button>

    <!-- Thông tin biến thể -->
    <div class="mt-4 mb-3">
        <label class="form-label">Tồn kho:</label>
        <input type="number" class="form-control" name="stock" min="0">
    </div>

    <div class="mb-3">
        <label class="form-label">Giá bán:</label>
        <input type="number" class="form-control" name="price" step="0.01">
    </div>

    <div class="mb-3">
        <label class="form-label">Giá gốc (theo sản phẩm):</label>
        <input type="text" class="form-control" id="oldprice" name="oldprice" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh đại diện:</label>
        <input type="file" class="form-control" name="thumbnail">
    </div>

    <button type="submit" class="btn btn-primary">💾 Lưu biến thể</button>
    <a href="<?= BASE_URL_ADMIN . '&action=variants-index' ?>" class="btn btn-outline-dark">Quay lại</a>
</form>



<script>
    const products = <?= json_encode($products) ?>;
    const attributeValues = <?= json_encode($attributeValues) ?>; // Dạng: { 'ATTR-COLOR': { 'VAL-RED': 'Đỏ', ... }, ... }

    // Cập nhật giá gốc khi chọn sản phẩm
    const priceMap = {};
    products.forEach(p => priceMap[p.id] = p.priceDefault);
    document.getElementById('productId').addEventListener('change', function () {
        const pid = this.value;
        document.getElementById('oldprice').value = priceMap[pid] ?? '';
    });

    // Cập nhật danh sách giá trị khi thay đổi thuộc tính
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('attr-select')) {
            const attrId = e.target.value;
            const values = attributeValues[attrId] || {};
            const valueSelect = e.target.closest('tr').querySelector('.value-select');
            valueSelect.innerHTML = '<option value="">-- Chọn giá trị --</option>';
            for (const [valId, valName] of Object.entries(values)) {
                valueSelect.innerHTML += `<option value="${valId}">${valName}</option>`;
            }
        }
    });

    // Thêm dòng thuộc tính mới
    document.getElementById('addRow').addEventListener('click', function () {
        const tbody = document.querySelector('#attributeTable tbody');
        const clone = tbody.querySelector('tr').cloneNode(true);
        clone.querySelector('.attr-select').selectedIndex = 0;
        clone.querySelector('.value-select').innerHTML = '<option value="">-- Chọn giá trị --</option>';
        tbody.appendChild(clone);
    });

    // Xoá dòng
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            const tbody = document.querySelector('#attributeTable tbody');
            if (tbody.rows.length > 1) row.remove();
        }
    });
</script>