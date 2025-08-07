<div class="container py-5">
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert <?= $_SESSION['success'] ? 'alert-success' : 'alert-danger' ?>">
            <?= $_SESSION['msg'];
            unset($_SESSION['msg'], $_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <h2>Đổi mật khẩu</h2>
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert <?= $_SESSION['success'] ? 'alert-success' : 'alert-danger' ?>">
            <?= $_SESSION['msg'];
            unset($_SESSION['msg'], $_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="<?= BASE_URL ?>?action=change_password">
        <div class="mb-3">
            <label>Mật khẩu cũ</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div>