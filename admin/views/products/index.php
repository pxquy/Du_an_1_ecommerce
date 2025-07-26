<a href="<?= BASE_URL_ADMIN . '&action=products-create' ?>" class="btn btn-primary mb-3">Them moi</a>

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
        <th class="text-uppercase">thumbnail</th>
        <th class="text-uppercase">title</th>
        <th class="text-uppercase">price</th>
        <th class="text-uppercase">category</th>
        <th class="text-uppercase">brand</th>
        <th class="text-uppercase">rating</th>
        <th class="text-uppercase">stock</th>
        <th class="text-uppercase">isActive</th>
        <th class="text-uppercase">Action</th>
    </tr>
    <?php foreach ($data as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td>
                <?php if (!empty($product['thumbnail'])): ?>
                    <img src="<?= PATH_ASSETS_UPLOADS . $product['thumbnail'] ?>" alt="" width="100px">
                <?php else: ?>
                    <img src="<?= PATH_ASSETS_UPLOADS . 'products/placehold.png' ?>" alt="" width="100px">
                <?php endif ?>
            </td>
            <td><?= $product['title'] ?></td>
            <td><?= $product['priceDefault'] ?></td>
            <td><?= $product['categoryTitle'] ?></td>
            <td><?= $product['brandTitle'] ?></td>
            <td><?= $product['rating'] ?></td>
            <td><?= $product['stock'] ?></td>
            <td><?= $product['isActive'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=products-show&id=' . $product['id'] ?>" class="btn btn-info">Xem chi
                    tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=products-edit&id=' . $product['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <?php if ($product['isActive'] == 1): ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=products-softDelete&id=' . $product['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa Mem</a>
                <?php else: ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=products-restore&id=' . $product['id'] ?>"
                        onclick="return confirm('co chac khoi phuc khong?')" class="btn btn-success">Khoi phuc</a>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>