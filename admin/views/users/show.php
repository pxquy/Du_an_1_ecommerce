<table class="table">
    <?php foreach ($user as $key => $value): ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php
            switch ($key) {
                case 'avatarUrl':
                    if (!empty($value)) {
                        $link = BASE_ASSETS_UPLOADS . $value;
                        echo "<img src = '$link' width='100px'/>";
                    } else {
                        $link = BASE_ASSETS_UPLOADS . 'users/placehold.png';
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
<a href="<?= BASE_URL_ADMIN . '&action=users-edit&id=' . $user['id'] ?>" class="btn btn-warning">Sua</a>
<a href="<?= BASE_URL_ADMIN . '&action=users-delete&id=' . $user['id'] ?>" onclick="return confirm('co chac xoa khong?')"
    class="btn btn-danger">Xoa</a>
<a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>