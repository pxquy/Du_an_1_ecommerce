<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<?php
if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($_SESSION['errors'] as $value): ?>
                <li><?= $value ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=users-update&id=' . $user['id'] ?>" method="post"
    enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="fullname" class="form-label">Name:</label>
        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $user['fullname'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email:</label>$
        <input type="text" class="form-control" id="email" name="email" value="<?= $user['email'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="password" class="form-label">Password:</label>
        <input type="text" class="form-control" id="password" name="password" value="<?= $user['password'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="phone_number" class="form-label">phone:</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number"
            value="<?= $user['phone_number'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="gender" class="form-label">gender:</label>
        <input type="radio" id="male" name="gender" value="1" <?= ($user['gender'] == 1 ? 'checked' : '') ?>>
        <label for="male">Nam</label>
        <input type="radio" id="female" name="gender" value="2" <?= ($user['gender'] == 2 ? 'checked' : '') ?>>
        <label for="female">Nữ</label>
    </div>
    <div class="mb-3 mt-3">
        <label for="address" class="form-label">address:</label>
        <input type="text" class="form-control" id="address" name="address" value="<?= $user['address'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="avatarUrl" class="form-label">Avatar:</label>
        <input type="file" class="form-control" id="avatarUrl" name="avatarUrl">
        <?php if (!empty($user['avatarUrl'])): ?>
            <img src="<?= BASE_ASSETS_UPLOADS . $user['avatarUrl'] ?>" alt="" width="100px">
        <?php endif ?>
    </div>
    <div class="mb-3 mt-3">
        <label for="bio" class="form-label">Bio:</label>
        <input type="textarea" class="form-control" id="bio" name="bio" value="<?= $user['bio'] ?? null ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>