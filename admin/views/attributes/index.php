<a href="<?= BASE_URL_ADMIN . '&action=attributes-create' ?>" class="btn btn-primary mb-3">Them moi</a>

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
        <th class="text-uppercase">name</th>
        <th class="text-uppercase">attributeCode </th>
        <th class="text-uppercase">description</th>
        <th class="text-uppercase">isActive</th>
        <th class="text-uppercase">createdAt</th>
        <th class="text-uppercase">updatedAt</th>
        <th class="text-uppercase">Action</th>
    </tr>
    <?php foreach ($data as $attributes): ?> 
        <tr>
            <td><?= $attributes['id'] ?></td>
            <td><?= $attributes['name'] ?></td>
                <td><?= $attributes['attributeCode'] ?></td>
            <td><?= $attributes['description'] ?></td>
            <td><?= $attributes['isActive'] ?></td>
            <td><?= $attributes['createdAt'] ?></td>
            <td><?= $attributes['updatedAt'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=attributes-show&id=' . $attributes['id'] ?>" class="btn btn-info">Xem
chi tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=attributes-edit&id=' . $attributes['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=attributes-delete&id=' . $attributes['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>