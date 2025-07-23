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

<form action="<?= BASE_URL_ADMIN . '&action=brands-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="title" class="form-label">title:</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3 mt-3">
        <label for="description" class="form-label">description:</label>
        <input type="text" class="form-control" id="description" name="description">
    </div>
    <div class="mb-3 mt-3">
        <label for="seoTitle" class="form-label">Seo Title:</label>
        <input type="text" class="form-control" id="seoTitle" name="seoTitle">
    </div>
    <div class="mb-3 mt-3">
        <label for="seoDescription" class="form-label">Seo Description</label>
        <input type="text" class="form-control" id="seoDescription" name="seoDescription">
    </div>
    <div class="mb-3 mt-3">
        <label for="isActive" class="form-label">is Active:</label>
        <input type="radio" id="disabled" name="isActive" value="0">
        <label for="disabled">disabled</label>
        <input type="radio" id="active" name="isActive" value="1">
        <label for="active">active</label>
    </div>
    <div class="mb-3 mt-3">
        <label for="logoUrl" class="form-label">Logo:</label>
        <input type="file" class="form-control" id="logoUrl" name="logoUrl">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=brands-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>