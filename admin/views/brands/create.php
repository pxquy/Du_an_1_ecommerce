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

<form action="<?= BASE_URL_ADMIN . '&action=brands-store' ?>" method="post" enctype="multipart/form-data"
    class="space-y-6 bg-white p-6 rounded-md shadow-md p-4">
    <div class="mb-3 mt-3">
        <h2 class="text-lg font-semibold mb-4">Chi tiết thương hiệu</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="title" class="block text-sm font-medium mb-1">Tên Thương Hiệu:</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="">
                <label for="seoTitle" class="block text-sm font-medium mb-1">Seo Title:</label>
                <input type="text" class="form-control" id="seoTitle" name="seoTitle">
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-medium mb-1">Mô tả *:</label>
                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                <label for="seoDescription" class="block text-sm font-medium mb-1">Seo Description</label>
                <textarea type="text" class="form-control" id="seoDescription" name="seoDescription"></textarea>
            </div>
        </div>
    </div>
    <div class="mb-3 mt-3">
        <label for="isActive" class="block text-sm font-medium mb-1">Trạng thái:</label>
        <input type="radio" id="disabled" name="isActive" value="0">
        <label for="disabled">Ngừng Hoạt động</label>
        <input type="radio" id="active" name="isActive" value="1">
        <label for="active">Hoạt động</label>
    </div>
    <div class="mb-3 mt-3">
        <h2 class="text-lg font-semibold mb-4">Hình ảnh</h2>
        <div>
            <label class="block text-sm font-medium mb-1" for="brandImage">Chọn hình ảnh</label>
            <input type="file"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                id="logoUrl" name="logoUrl">
        </div>
    </div>
    <div class="flex justify-end gap-4">
        <a href="<?= BASE_URL_ADMIN . '&action=brands-index' ?>"
            class="px-4 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100 no-un">
            Quay lại
        </a>
        <button type="submit" class="px-4 py-2 text-sm rounded bg-indigo-600 text-white hover:bg-indigo-700">
            Lưu thương hiệu
        </button>
    </div>
</form>

<style>
    a {
        text-decoration: none;
        color: gray;
    }
</style>
