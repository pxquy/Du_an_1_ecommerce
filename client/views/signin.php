<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Signin' ?></title>
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

        <form action="<?= BASE_URL . '?action=signin' ?>" method="post">
            <div class="mb-3 mt-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <?php unset($_SESSION['data']); ?>
    </div>
</body>

</html>