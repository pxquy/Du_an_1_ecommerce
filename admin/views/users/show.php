<table class="table">
    <?php foreach ($user as $key => $value): ?>
        <?php if ($key !== 'password'): // Bỏ qua password ?>
            <tr>
                <td><?= strtoupper($key) ?></td>
                <td>
                    <?php
                    switch ($key) {
                        case 'avatarUrl':
                            $link = BASE_ASSETS_UPLOADS . (!empty($value) ? $value : 'users/placehold.png');
                            echo "<img src='$link' width='100px'/>";
                            break;
                        default:
                            echo htmlspecialchars($value);
                            break;
                    }
                    ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

<a href="<?= BASE_URL_ADMIN . '&action=users-edit&id=' . $user['id'] ?>" class="btn btn-warning">Sửa</a>
<a href="<?= BASE_URL_ADMIN . '&action=users-delete&id=' . $user['id'] ?>"
    onclick="return confirm('Có chắc xóa không?')" class="btn btn-danger">Xóa</a>
<a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>" class="btn btn-secondary">Quay lại danh sách</a>