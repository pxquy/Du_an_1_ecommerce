<?php
if(isset($_SESSION['success'])){
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<?php 
if(!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($_SESSION['error'] as $value) : ?>
                <li><?= $value ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=products-store' ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="title" class="form-label">title:</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3 mt-3">
        <label for="description" class="form-label">description:</label>
        <input type="text" class="form-control" id="description" name="description">
    </div>
    <div class="mb-3 mt-3">
        <label for="shortDescription" class="form-label">short description:</label>
        <input type="text" class="form-control" id="shortDescription" name="shortDescription">
    </div>
    <div class="mb-3 mt-3">
        <label for="priceDefault" class="form-label">Price Default:</label>
        <input type="number" class="form-control" id="priceDefault" name="priceDefault" step="0.01" min="0"
            max="99999999.99">
    </div>
    <div class="mb-3 mt-3">
        <label for="discountPercentage" class="form-label">Discount Percentage:</label>
        <input type="number" class="form-control" id="discountPercentage" name="discountPercentage" step="0.01" min="0"
            max="99.99">
    </div>
    <div class="mb-3 mt-3">
        <label for="categoryId" class="form-label">Category: </label>
        <select name="categoryId" id="categoryId">
            <?php foreach ($categoryPluck as $id => $title): ?>
                <option value="<?= $id ?>"><?= $title ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3 mt-3">
        <label for="brandId" class="form-label">Brand: </label>
        <select name="brandId" id="brandId">
            <?php foreach ($brandPluck as $id => $title): ?>
                <option value="<?= $id ?>"><?= $title ?></option>
            <?php endforeach ?>
        </select>
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
        <input type="radio" id="active" name="isActive" value="1" checked>
        <label for="active">active</label>
    </div>
    <div class="mb-3 mt-3">
        <label for="thumbnail" class="form-label">Thumbnail:</label>
        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=products-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>