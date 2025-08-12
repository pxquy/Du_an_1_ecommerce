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

<form action="<?= BASE_URL_ADMIN . '&action=users-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3 rounded p-4 bg-white">
        <h5>Thông tin cơ bản</h5>
        <div>
            <label for="fullname" class="form-label">Họ và Tên:</label>
            <input type="text" class="form-control" id="fullname" name="fullname"
                value="<?= $_SESSION['data']['fullname'] ?? null ?>">
        </div>
        <div class="row">
            <div class="col">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email"
                    value="<?= $_SESSION['data']['email'] ?? null ?>">
            </div>
            <div class="col">
                <label for="password" class="form-label">Password:</label>
                <input type="text" class="form-control" id="password" name="password"
                    value="<?= $_SESSION['data']['password'] ?? null ?>">
            </div>
        </div>

    </div>

    <div class="mb-3 mt-3 rounded p-4 bg-white">
        <h5>Thông tin chi tiết</h5>
        <div class="row mb-3">
            <div class="col">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?= $_SESSION['data']['address'] ?? null ?>">
            </div>
            <div class="col">
                <label for="phone_number" class="form-label">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="<?= $_SESSION['data']['phone_number'] ?? null ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính:</label>
            <input type="radio" id="male" name="gender" value="1">
            <label for="male">Nam</label>
            <input type="radio" id="female" name="gender" value="2">
            <label for="female">Nữ</label>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Quyền:</label>
            <select name="role" id="role" class="form-select">
                <option value="0">Người dùng</option>
                <option value="1">Quản lý</option>
                <option value="2">Nhân viên</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Tiểu sử:</label>
            <textarea type="textarea" class="form-control" id="bio" name="bio"
                value="<?= $_SESSION['data']['bio'] ?? null ?>"></textarea>
        </div>
        <div class="mb-3 ">
            <label for="avatarUrl" class="form-label">Avatar:</label>
            <input type="file" class="form-control" id="avatarUrl" name="avatarUrl">
        </div>
    </div>
    <div class="flex justify-end gap-4">
        <a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>"
            class="rounded border border-gray-300 bg-white px-3 py-2 !no-underline hover:bg-gray-100 hover:border-gray-800 hover:border-2 hover:text-gray-800 transition-all duration-200 ease-in-out">
            <span class="text-gray-600 font-medium">Quay lại</span>
        </a>
        <button type="submit"
            class="rounded bg-indigo-600 px-3 py-2 text-white font-medium hover:bg-indigo-700 hover:shadow-md transition-all duration-200 ease-in-out">
            Lưu người dùng
        </button>
    </div>


</form>