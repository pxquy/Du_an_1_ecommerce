<a href="<?= BASE_URL_ADMIN . '&action=attributeValues-create' ?>" class="btn btn-primary mb-3">Them moi</a>

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
        <th class="text-uppercase">value</th>
        <th class="text-uppercase">valueCode </th>
        <th class="text-uppercase">attributeId</th>
        <th class="text-uppercase">isActive</th>
        <th class="text-uppercase">createdAt</th>
        <th class="text-uppercase">updatedAt</th>
        <th class="text-uppercase">Action</th>
    </tr>
    <?php foreach ($data as $attributeValue): ?>
        <tr>
            <td><?= $attributeValue['id'] ?></td>
            <td><?= $attributeValue['value'] ?></td>
            <td><?= $attributeValue['valueCode'] ?></td>
            <td><?= $attributeValue['attributeId'] ?></td>
            <td><?= $attributeValue['isActive'] ?></td>
            <td><?= $attributeValue['createdAt'] ?></td>
            <td><?= $attributeValue['updatedAt'] ?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=attributeValues-show&id=' . $attributeValue['id'] ?>"
                    class="btn btn-info">Xem
                    chi tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=attributeValues-edit&id=' . $attributeValue['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=attributeValues-delete&id=' . $attributeValue['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>