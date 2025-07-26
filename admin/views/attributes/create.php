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
            <?php foreach ($_SESSION['error'] as $value): ?>
                <li><?= $value ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=attributes-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="name" class="form-label">name:</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3 mt-3">
        <label for="description" class="form-label">description:</label>
        <input type="text" class="form-control" id="description" name="description">
    </div>
    <div class="mb-3 mt-3">
        <label for="isActive" class="form-label">is Active:</label>
        <input type="radio" id="disabled" name="isActive" value="0">
        <label for="disabled">disabled</label>
        <input type="radio" id="active" name="isActive" value="1" checked>
        <label for="active">active</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=attributes-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>