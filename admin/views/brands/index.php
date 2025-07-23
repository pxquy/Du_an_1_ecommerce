<a href="<?= BASE_URL_ADMIN . '&action=brands-create' ?>" class="btn btn-primary mb-3">Them moi</a>

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
        <th class="text-uppercase">logoUrl</th>
        <th class="text-uppercase">title </th>
        <th class="text-uppercase">description</th>
        <th class="text-uppercase">slug </th>
        <th class="text-uppercase">is Active</th>
        <th class="text-uppercase">Action</th>
    </tr>
    <?php foreach ($data as $brand): ?>
        <tr>
            <td><?= $brand['id'] ?></td>
            <td>
                <?php if (!empty($brand['logoUrl'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $brand['logoUrl'] ?>" alt="" width="100px">
                <?php else: ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . 'brands/placehold.png' ?>" alt="" width="100px">
                <?php endif ?>
            </td>
            <td><?= $brand['title'] ?></td>
            <td><?= $brand['description'] ?></td>
            <td><?= $brand['slug'] ?></td>
            <td><?= $brand['isActive'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=brands-show&id=' . $brand['id'] ?>" class="btn btn-info">Xem chi
                    tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=brands-edit&id=' . $brand['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <?php if ($brand['isActive'] == 1): ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=brands-softDelete&id=' . $brand['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa Mem</a>
                <?php else: ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=brands-restore&id=' . $brand['id'] ?>"
                        onclick="return confirm('co chac khoi phuc khong?')" class="btn btn-success">Khoi phuc</a>
                    <a href="<?= BASE_URL_ADMIN . '&action=brands-delete&id=' . $brand['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa Cung</a>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>