<h2><?= htmlspecialchars($productDetail['title'] ?? 'Sản phẩm') ?></h2>

<!-- Ảnh chính -->
<img src="<?= htmlspecialchars($productDetail['thumbnail'] ?? '') ?>" alt="Ảnh sản phẩm" width="300">

<!-- Danh sách ảnh phụ -->
<h3>Ảnh mô tả:</h3>
<div>
    <?php foreach ($images as $img): ?>
        <?php if (!empty($img)): ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="Hình phụ" width="100">
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<hr>

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

<!-- Thông tin biến thể -->
<div id="variant-info" style="margin-top: 10px;">
    <p><strong>Giá:</strong> <span id="variant-price">--</span></p>
    <p><strong>Tồn kho:</strong> <span id="variant-stock">--</span></p>
</div>

<!-- Form thêm vào giỏ hàng -->
<form action="?action=add_to_cart" method="POST" id="addCartForm">
    <input type="hidden" name="productId" value="<?= $productDetail['id'] ?>">
    <input type="hidden" name="variantId" id="variantId">
    <input type="hidden" name="price" id="variantPriceInput">

    <label for="quantity">Số lượng:</label>
    <input type="number" name="quantity" id="quantity" value="1" min="1">

    <button type="submit" id="btnAddCart" disabled>Thêm vào giỏ hàng</button>
</form>

<script>
    const variantsData = <?= json_encode($variants) ?>;
    const variantAttributes = <?= json_encode($variantAttributes) ?>;
    let selectedColor = null;
    let selectedSize = null;

    document.querySelectorAll('input[name="color"]').forEach(input => {
        input.addEventListener('change', () => {
            selectedColor = input.value;
            document.getElementById('selectedColor').textContent =
                input.closest('label').querySelector('.color-swatch').dataset.colorName;
            updateVariantInfo();
        });
    });

    document.querySelectorAll('input[name="size"]').forEach(input => {
        input.addEventListener('change', () => {
            selectedSize = input.value;
            document.getElementById('selectedSize').textContent =
                input.closest('label').querySelector('.size-box').textContent;
            updateVariantInfo();
        });
    });

    function updateVariantInfo() {
        if (!selectedColor || !selectedSize) return;

        for (const variant of variantsData) {
            const attrValues = (variantAttributes[variant.id] || []).map(a => a.valueId);
            if (attrValues.includes(parseInt(selectedColor)) && attrValues.includes(parseInt(selectedSize))) {
                document.getElementById('variant-price').innerText = Number(variant.price).toLocaleString() + 'đ';
                document.getElementById('variant-stock').innerText = variant.stock;

                document.getElementById('variantId').value = variant.id;
                document.getElementById('variantPriceInput').value = variant.price;
                document.getElementById('btnAddCart').disabled = false;
                return;
            }
        }

        document.getElementById('btnAddCart').disabled = true;
    }
</script>

<style>
    .color-option input[type="radio"] {
        display: none;
    }

    .color-swatch {
        display: inline-block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .size-option input[type="radio"] {
        display: none;
    }

    .size-box {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #ccc;
        margin-right: 5px;
        cursor: pointer;
    }

    button:disabled {
        background: #aaa;
        cursor: not-allowed;
    }
</style>