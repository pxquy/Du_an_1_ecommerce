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

<form action="<?= BASE_URL_ADMIN . '&action=categories-update&id=' . $category['id'] ?>" method="post"
    enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="title" class="form-label">title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $category['title'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="description" class="form-label">description:</label>
        <input type="text" class="form-control" id="description" name="description"
            value="<?= $category['description'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="seoTitle" class="form-label">Seo Title:</label>
        <input type="text" class="form-control" id="seoTitle" name="seoTitle"
            value="<?= $category['seoTitle'] ?? null ?>">
    </div>
    <div class="mb-3 mt-3">
        <label for="seoDescription" class="form-label">Seo Description</label>
        <input type="text" class="form-control" id="seoDescription" name="seoDescription"
            value="<?= $category['seoDescription'] ?? null ?>">
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
        <?php if (!empty($category['logoUrl'])): ?>
            <img src="<?= BASE_ASSETS_UPLOADS . $category['logoUrl'] ?>" alt="" width="100px">
        <?php endif ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>