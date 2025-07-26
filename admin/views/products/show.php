<table class="table">
    <?php foreach ($product as $key => $value): ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php 
            switch ($key) {
                    case 'avatarUrl':
                    if (!empty($value)) {
                            $link = PATH_ASSETS_UPLOADS . $value;
                            echo "<img src = '$link' width='100px'/>";
                        } else {
                            $link = PATH_ASSETS_UPLOADS . 'products/placehold.png';
                            echo "<img src = '$link' width = '100px'/>";
                        }
                        break;
                    default:
                        echo $value;
                        break;
                }    
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
</table>
<h1>Bang variant cua san pham</h1>
<a href="<?= BASE_URL_ADMIN . '&action=variantsx-create' ?>" class="btn btn-primary mb-3">Them moi bien the</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>SKU</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Old Price</th>
            <th>Attribute</th>
            <th>Attribute Value</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productVariants as $variant): ?>
            <tr>
                <td><?= $variant['variantId'] ?? '' ?></td>
                <td>
                    <?php
                    $image = $variant['avatarUrl'] ?? 'products/placehold.png';
                    $link = PATH_ASSETS_UPLOADS . $image;
                    echo "<img src='$link' width='100px'/>";
                    ?>
                </td>
                <td><?= $variant['sku'] ?? '' ?></td>
                <td><?= $variant['stock'] ?? '' ?></td>
                <td><?= number_format($variant['price'] ?? 0) ?></td>
                <td><?= number_format($variant['oldPrice'] ?? 0) ?></td>
                <td><?= $variant['attributeName'] ?? '' ?></td>
                <td><?= $variant['attributeValue'] ?? '' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= BASE_URL_ADMIN . '&action=products-edit&id=' . $product['id'] ?>" class="btn btn-warning">Sua</a>
<a href="<?= BASE_URL_ADMIN . '&action=products-delete&id=' . $product['id'] ?>"
    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
<a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>