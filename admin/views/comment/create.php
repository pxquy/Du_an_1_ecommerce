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

<form action="<?= BASE_URL_ADMIN . '&action=users-store'?>" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="fullname" class="form-label">Name:</label>
        <input type="text" class="form-control" id="fullname" name="fullname">
    </div>
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3 mt-3">
        <label for="Password" class="form-label">Password:</label>
        <input type="text" class="form-control" id="Password" name="Password">
    </div>
    <div class="mb-3 mt-3">
        <label for="phone_number" class="form-label">phone:</label>
        <input type="text" class="form-control" id="phone_number" name="phone_number">
    </div>
    <div class="mb-3 mt-3">
        <label for="gender" class="form-label">gender:</label>
        <input type="radio" id="male" name="gender" value="1">
        <label for="male">Nam</label>
        <input type="radio" id="female" name="gender" value="2">
        <label for="female">Nữ</label>
    </div>
    <div class="mb-3 mt-3">
        <label for="address" class="form-label">address:</label>
        <input type="text" class="form-control" id="address" name="address">
    </div>
    <div class="mb-3 mt-3">
        <label for="avatar" class="form-label">Avatar:</label>
        <input type="file" class="form-control" id="avatar" name="avatar">
    </div>
    <div class="mb-3 mt-3">
        <label for="bio" class="form-label">Bio:</label>
        <input type="textarea" class="form-control" id="bio" name="bio">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

    <a href="<?= BASE_URL_ADMIN . '&action=users-index' ?>" class="btn btn-secondary">Quay lai</a>
</form>
