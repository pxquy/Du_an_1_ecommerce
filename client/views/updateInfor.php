<div class="container py-5">
    <h2>Cập nhật thông tin cá nhân</h2>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert <?= $_SESSION['success'] ? 'alert-success' : 'alert-danger' ?>">
            <?= $_SESSION['msg'];
            unset($_SESSION['msg'], $_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>?action=update_info" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="fullname">Họ tên</label>
            <input type="text" class="form-control" name="fullname" required
                value="<?= htmlspecialchars($_SESSION['user']['fullname']) ?>">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email"
                value="<?= htmlspecialchars($_SESSION['user']['email']) ?>">
        </div>

        <div class="mb-3">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" name="phone"
                value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control" name="address"
                value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="gender">Giới tính</label>
            <select name="gender" class="form-control">
                <option value="1" <?= ($_SESSION['user']['gender'] ?? '') === '1' ? 'selected' : '' ?>>Nam</option>
                <option value="0" <?= ($_SESSION['user']['gender'] ?? '') === '0' ? 'selected' : '' ?>>Nữ</option>
            </select>

        </div>

        <div class="mb-3">
            <label for="avatar">Ảnh đại diện</label><br>
            <?php if (!empty($_SESSION['user']['avatarUrl'])): ?>
                <img src="<?= BASE_URL ?>public/uploads/users/<?= $_SESSION['user']['avatarUrl'] ?>" width="100"
                    class="mb-2" alt="Avatar">
            <?php endif; ?>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>