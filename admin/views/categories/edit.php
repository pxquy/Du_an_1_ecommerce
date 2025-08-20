<?php if (isset($_SESSION['success'])): ?>
    <div
        class="<?= $_SESSION['success'] ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?> px-4 py-3 rounded mb-4">
        <?= $_SESSION['msg'] ?>
    </div>
    <?php unset($_SESSION['success'], $_SESSION['msg']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5 text-sm">
            <?php foreach ($_SESSION['error'] as $value): ?>
                <li><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<form action="<?= BASE_URL_ADMIN . '&action=categories-update&id=' . $category['id'] ?>" method="post"
    enctype="multipart/form-data" class="space-y-6 bg-white rounded-md shadow-md p-4">
    <div class="mb-3 mt-3">
        <h2 class="text-lg font-semibold mb-4">Cập nhật danh mục <?= $category['title'] ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="title" class="block text-sm font-medium mb-1">Tên danh mục:</label>
                <input type="text" id="title" name="title" value="<?= $category['title'] ?? '' ?>"
                    class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="seoTitle" class="block text-sm font-medium mb-1">Seo Title:</label>
                <input type="text" id="seoTitle" name="seoTitle" value="<?= $category['seoTitle'] ?? '' ?>"
                    class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-medium mb-1">Mô tả:</label>
                <input type="text" id="description" name="description" value="<?= $category['description'] ?? '' ?>"
                    class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <div class="sm:col-span-2">
                <label for="seoDescription" class="block text-sm font-medium mb-1">Seo Description:</label>
                <input type="text" id="seoDescription" name="seoDescription"
                    value="<?= $category['seoDescription'] ?? '' ?>"
                    class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
        </div>
    </div>

    <div class="mb-3 mt-3">
        <label class="block text-sm font-medium mb-1">Trạng thái:</label>
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-1 text-sm">
                <input type="radio" id="disabled" name="isActive" value="0"
                    class="text-indigo-600 focus:ring-indigo-500" <?= $category['isActive'] == 0 ? 'checked' : '' ?>>
                <span>Ngừng hoạt động</span>
            </label>
            <label class="flex items-center gap-1 text-sm">
                <input type="radio" id="active" name="isActive" value="1" class="text-indigo-600 focus:ring-indigo-500"
                    <?= $category['isActive'] == 1 ? 'checked' : '' ?>>
                <span>Hoạt động</span>
            </label>
        </div>
    </div>

    <div class="mb-3 mt-3">
        <h2 class="text-lg font-semibold mb-4">Hình ảnh danh mục</h2>
        <label for="logoUrl" class="block text-sm font-medium mb-1">Tải lên logo:</label>
        <input type="file" id="logoUrl" name="logoUrl" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0 file:text-sm file:font-semibold
                      file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
        <?php if (!empty($category['logoUrl'])): ?>
            <img src="<?= BASE_ASSETS_UPLOADS . $category['logoUrl'] ?>" alt="Logo"
                class="mt-2 w-24 h-auto rounded border" />
        <?php endif ?>
    </div>

    <div class="flex justify-end gap-4">
        <a href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>"
            class="px-4 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100 text-gray-700">
            Quay lại
        </a>
        <button type="submit" class="px-4 py-2 text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
            Lưu danh mục
        </button>
    </div>
</form>