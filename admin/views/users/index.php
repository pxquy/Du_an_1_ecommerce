<a href="<?= BASE_URL_ADMIN . '&action=users-create' ?>" class="btn btn-primary mb-3">Them moi</a>

<?php
if(isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<table class="table">
    <tr>
        <th class="text-uppercase">ID</th>
        <th class="text-uppercase">Full Name</th>
        <th class="text-uppercase">email</th>
        <th class="text-uppercase">password</th>
        <th class="text-uppercase">bio</th>
        <th class="text-uppercase">avatar</th>
        <th class="text-uppercase">role</th>
        <th class="text-uppercase">phone number</th>
        <th class="text-uppercase">is Active</th>
        <th class="text-uppercase">address</th>
        <th class="text-uppercase">gender</th>
        <th class="text-uppercase">created At</th>
        <th class="text-uppercase">updated At</th>
        <th class="text-uppercase">Action</th>
    </tr>
    <?php foreach ($data as $user): ?> 
        <tr>
            <td><?= $user['id']?></td>
            <td><?= $user['fullname']?></td>
            <td><?= $user['email']?></td>
            <td><?= $user['password']?></td>
            <td><?= $user['bio']?></td>
            <td><?= $user['avatarUrl']?></td>
            <td><?= $user['role']?></td>
            <td><?= $user['phone_number']?></td>
            <td><?= $user['isActive']?></td>
            <td><?= $user['address']?></td>
            <td><?= $user['gender']?></td>
            <td><?= $user['createdAt']?></td>
            <td><?= $user['updatedAt']?></td>
            <td>
                <a href="<?= BASE_URL_ADMIN . '&action=users-show&id='. $user['id'] ?>"
                    class="btn btn-info">Xem chi tiet</a>
                <a href="<?= BASE_URL_ADMIN . '&action=users-edit&id='. $user['id'] ?>"
                    class="btn btn-warning ms-3 me-3">Sua</a>
                <a href="<?= BASE_URL_ADMIN . '&action=users-delete&id='. $user['id'] ?>"
                    onclick="return confirm('co chac xoa khong?')"
                    class="btn btn-danger">Xoa</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>