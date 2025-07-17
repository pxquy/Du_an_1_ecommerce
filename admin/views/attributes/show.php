<table class="table">
    <?php foreach ($attributes as $key => $value): ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php 
            switch ($key) {
                    case 'avatarUrl':
                    if (!empty($value)) {
                            $link = PATH_ASSETS_UPLOADS . $value;
                            echo "<img src = '$link' width='100px'/>";
                        } else {
                        $link = PATH_ASSETS_UPLOADS . 'attributes/placehold.png';
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
<h1>Bang value cua thuoc tinh</h1>
<a href="<?= BASE_URL_ADMIN . '&action=variantsx-create' ?>" class="btn btn-primary mb-3">Them moi bien the</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>value</th>
            <th>valueCode</th>
            <th>isActive</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attributeValues as $value): ?>
            <tr>
                <td><?= $value['id'] ?? '' ?></td>
                <td><?= $value['value'] ?? '' ?></td>
                <td><?= $value['valueCode'] ?? '' ?></td>
                <td><?= $value['isActive'] ?? '' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= BASE_URL_ADMIN . '&action=attributes-edit&id=' . $attributes['id'] ?>" class="btn btn-warning">Sua</a>
<a href="<?= BASE_URL_ADMIN . '&action=attributes-delete&id=' . $attributes['id'] ?>"
    onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
<a href="<?= BASE_URL_ADMIN . '&action=attributes-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>
