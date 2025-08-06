<table class="table">
    <?php foreach($category as $key => $value) : ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php 
                switch($key){
                    case 'avatarUrl':
                        if(!empty($value)){
                            $link = PATH_ASSETS_UPLOADS . $value;
                            echo "<img src = '$link' width='100px'/>";
                        } else {
                            $link = PATH_ASSETS_UPLOADS . 'users/placehold.png';
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
<a href="<?= BASE_URL_ADMIN . '&action=categories-edit&id='. $category['id'] ?>"
                    class="btn btn-warning">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=categories-delete&id='. $category['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')"
                    class="btn btn-danger">Xoa</a>
<a href="<?=BASE_URL_ADMIN . '&action=categories-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>