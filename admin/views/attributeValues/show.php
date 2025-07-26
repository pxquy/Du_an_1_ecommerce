<table class="table">
    <?php foreach ($attributeValue as $key => $value): ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php 
            switch ($key) {
                    default:
                        echo $value;
                        break;
                }    
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
</table>
<a href="<?= BASE_URL_ADMIN . '&action=attributeValues-edit&id=' . $attributeValue['id'] ?>"
                    class="btn btn-warning">Sua</a>
<a href="<?= BASE_URL_ADMIN . '&action=attributeValues-delete&id=' . $attributeValue['id'] ?>"
    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
<a href="<?= BASE_URL_ADMIN . '&action=attributeValues-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>