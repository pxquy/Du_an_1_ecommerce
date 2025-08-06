<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<?php if (!empty($_SESSION['errors'])): ?>
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
    <div class="mb-3 mt-3 rounded p-4 bg-white">
        <h5>Thông tin cơ bản</h5>
        <div>
            <label for="fullname" class="form-label">Họ và Tên:</label>
            <input type="text" class="form-control" id="fullname" name="fullname"
                value="<?= $user['fullname'] ?? '' ?>">
        </div>
        <div class="row">
            <div class="col">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $user['email'] ?? '' ?>">
            </div>
            <div class="col">
                <label for="password" class="form-label">Password:</label>
                <input type="text" class="form-control" id="password" name="password"
                    value="<?= $user['password'] ?? '' ?>">
            </div>
        </div>
    </div>

    <div class="mb-3 mt-3 rounded p-4 bg-white">
        <h5>Thông tin chi tiết</h5>
        <div class="row mb-3">
            <div class="col">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?= $user['address'] ?? '' ?>">
            </div>
            <div class="col">
                <label for="phone_number" class="form-label">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="<?= $user['phone_number'] ?? '' ?>">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Giới tính:</label><br>
            <input type="radio" id="male" name="gender" value="1" <?= $user['gender'] == 1 ? 'checked' : '' ?>>
            <label for="male">Nam</label>
            <input type="radio" id="female" name="gender" value="2" <?= $user['gender'] == 2 ? 'checked' : '' ?>>
            <label for="female">Nữ</label>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Tiểu sử:</label>
            <textarea class="form-control" id="bio" name="bio"><?= $user['bio'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label for="avatarUrl" class="form-label">Avatar:</label>
            <input type="file" class="form-control" id="avatarUrl" name="avatarUrl">
            <?php if (!empty($user['avatarUrl'])): ?>
                <img src="<?= BASE_ASSETS_UPLOADS . $user['avatarUrl'] ?>" alt="" width="100" class="mt-2 rounded">
            <?php endif ?>
        </div>
    </div>

    <div class="flex justify-end gap-4">
        <a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>"
            class="rounded border border-gray-300 bg-white px-3 py-2 !no-underline hover:bg-gray-100 hover:border-gray-800 hover:border-2 hover:text-gray-800 transition-all duration-200 ease-in-out">
            <span class="text-gray-600 font-medium">Quay lại</span>
        </a>
        <button type="submit"
            class="rounded bg-indigo-600 px-3 py-2 text-white font-medium hover:bg-indigo-700 hover:shadow-md transition-all duration-200 ease-in-out">
            Cập nhật người dùng
        </button>
    </div>
</form>