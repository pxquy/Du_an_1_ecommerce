<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Signup' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <?php
        if (isset($_SESSION['success'])) {
            $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
            echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
            unset($_SESSION['success'], $_SESSION['msg']);
        }

        if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['error'] as $value): ?>
                        <li><?= $value ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL . '?action=createUser' ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fullname" class="form-label">Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname"
                    value="<?= $_SESSION['data']['fullname'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email"
                    value="<?= $_SESSION['data']['email'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                    value="<?= $_SESSION['data']['password'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="<?= $_SESSION['data']['phone_number'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="1"
                    <?= (isset($_SESSION['data']['gender']) && $_SESSION['data']['gender'] == 1) ? 'checked' : '' ?>>
                <label for="male">Nam</label>

                <input type="radio" id="female" name="gender" value="2"
                    <?= (isset($_SESSION['data']['gender']) && $_SESSION['data']['gender'] == 2) ? 'checked' : '' ?>>
                <label for="female">Nữ</label>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?= $_SESSION['data']['address'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="avatarUrl" class="form-label">Avatar:</label>
                <input type="file" class="form-control" id="avatarUrl" name="avatarUrl">
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Bio:</label>
                <textarea class="form-control" id="bio" name="bio"><?= $_SESSION['data']['bio'] ?? '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <a href="<?= BASE_URL ?>" class="btn btn-secondary">Quay lại</a>
        </form>
        <?php unset($_SESSION['data']); ?>
    </div>
</body>

</html>