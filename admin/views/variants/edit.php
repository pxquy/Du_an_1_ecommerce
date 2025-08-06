<script>
    const existingCombinations = <?= $existingCombinationsJson ?>;

    function getCurrentCombination(row) {
        const selects = row.querySelectorAll('select');
        let values = [];
        selects.forEach(select => {
            values.push(select.value);
        });
        return values.sort().join('-');
    }

    function updateDisabledOptions() {
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const currentCombination = getCurrentCombination(row);

            row.querySelectorAll('select').forEach(select => {
                const originalValue = select.value;

                select.querySelectorAll('option').forEach(option => {
                    select.value = option.value;

                    const testCombination = getCurrentCombination(row);

                    if (existingCombinations.includes(testCombination) && testCombination !== currentCombination) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });

                select.value = originalValue;
            });
        });
    }

    window.addEventListener('DOMContentLoaded', updateDisabledOptions);
    document.querySelectorAll('select').forEach(s => s.addEventListener('change', updateDisabledOptions));
</script>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<h2>Cập nhật biến thể: <?= htmlspecialchars($productDetail['title']) ?></h2>

<form method="POST" action="<?= BASE_URL_ADMIN . '&action=variants-update&productId=' . $productDetail['id'] ?>">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <?php
                // Lấy danh sách các thuộc tính từ biến thể đầu tiên
                $attributes = [];
                if (!empty($productDetail['variants'][0]['attributes'])) {
                    foreach ($productDetail['variants'][0]['attributes'] as $attr) {
                        $attributes[$attr['attributeId']] = $attr['attributeName'];
                    }
                }

                foreach ($attributes as $attrName) {
                    echo "<th>" . htmlspecialchars($attrName) . "</th>";
                }
                ?>
                <th>Giá</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productDetail['variants'] as $variant): ?>
                <tr>
                    <td><?= $variant['id'] ?></td>

                    <?php foreach ($variant['attributes'] as $attr): ?>
                        <td>
                            <select name="variants[<?= $variant['id'] ?>][attributes][<?= $attr['attributeId'] ?>]"
                                class="form-select">
                                <?php foreach ($allValuesByAttribute[$attr['attributeId']] as $option): ?>
                                    <option value="<?= $option['id'] ?>" <?= $option['id'] == $attr['valueId'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($option['value']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    <?php endforeach; ?>

                    <td>
                        <input type="number" name="variants[<?= $variant['id'] ?>][price]" value="<?= $variant['price'] ?>"
                            class="form-control" step="0.01" />
                    </td>
                    <td>
                        <input type="number" name="variants[<?= $variant['id'] ?>][stock]" value="<?= $variant['stock'] ?>"
                            class="form-control" />
                    </td>
                    <td>
                        <a href="<?= BASE_URL_ADMIN . '&action=variants-delete&id=' . $variant['id'] . '&productId=' . $variant['productId'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc muốn xoá biến thể này không?')">Xoá</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Cập nhật tất cả</button>
</form>