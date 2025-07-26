<a href="<?= BASE_URL_ADMIN . '&action=variants-create' ?>" class="btn btn-primary mb-3">Them moi</a>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<table class="table">
    <tr>
        <th class="text-uppercase">ID</th>
        <th class="text-uppercase">imageUrl</th>
        <th class="text-uppercase">product</th>
        <th class="text-uppercase">attribute</th>
        <th class="text-uppercase">value</th>
        <th class="text-uppercase">stock</th>
        <th class="text-uppercase">price</th>
        <th class="text-uppercase">oldPrice</th>
        <th class="text-uppercase">sku</th>
    </tr>
    <?php foreach ($data as $variants): ?>
        <tr>
            <td><?= $variants['id'] ?></td>
            <td><?= $variants['imageUrl'] ?></td>
            <td><?= $variants['productTitle'] ?></td>
            <td><?= $variants['attributeName'] ?></td>
            <td><?= $variants['attributeValue'] ?></td>
            <td><?= $variants['stock'] ?></td>
            <td><?= $variants['price'] ?></td>
            <td><?= $variants['oldPrice'] ?></td>
            <td><?= $variants['SKU'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=variants-show&id=' . $variants['id'] ?>" class="btn btn-info">Xem
                    chi tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=variants-edit&id=' . $variants['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=variants-delete&id=' . $variants['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>