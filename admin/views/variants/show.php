<table class="table">
    <?php foreach($attributes as $key => $value) : ?>
        <tr>
            <td><?= strtoupper($key) ?></td>
            <td><?php 
                switch($key){
                    case 'avatarUrl':
                        if(!empty($value)){
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
<a href="<?= BASE_URL_ADMIN . '&action=attributes-edit&id='. $attributes['id'] ?>"
                    class="btn btn-warning">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=attributes-delete&id='. $attributes['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')"
                    class="btn btn-danger">Xoa</a>
<a href="<?=BASE_URL_ADMIN . '&action=attributes-index' ?>" class="btn btn-secondary">Quay Lại danh sách</a>