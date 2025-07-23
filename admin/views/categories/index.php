<a href="<?= BASE_URL_ADMIN . '&action=categories-create' ?>" class="btn btn-primary mb-3">Them moi</a>

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
    <?php foreach ($data as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td>
                <?php if (!empty($category['logoUrl'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $category['logoUrl'] ?>" alt="" width="100px">
                <?php else: ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . 'categories/placehold.png' ?>" alt="" width="100px">
                <?php endif ?>
            </td>
            <td><?= $category['title'] ?></td>
            <td><?= $category['description'] ?></td>
            <td><?= $category['slug'] ?></td>
            <td><?= $category['isActive'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=categories-show&id=' . $category['id'] ?>" class="btn btn-info">Xem chi
                    tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=categories-edit&id=' . $category['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <?php if ($category['isActive'] == 1): ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=categories-softDelete&id=' . $category['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa Mem</a>
                <?php else: ?>
                    <a href="<?= BASE_URL_ADMIN . '&action=categories-restore&id=' . $category['id'] ?>"
                        onclick="return confirm('co chac khoi phuc khong?')" class="btn btn-success">Khoi phuc</a>
                    <a href="<?= BASE_URL_ADMIN . '&action=categories-delete&id=' . $category['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa Cung</a>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>