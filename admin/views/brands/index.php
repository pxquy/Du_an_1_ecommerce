<a href="<?= BASE_URL_ADMIN . '&action=brands-create' ?>" class="btn btn-primary mb-3">Thêm mới</a>

<?php if (isset($_SESSION['success'])): ?>
    <div
        class="<?= $_SESSION['success'] ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?> px-4 py-3 rounded mb-4">
        <?= $_SESSION['msg'] ?>
    </div>
    <?php unset($_SESSION['success'], $_SESSION['msg']); ?>
<?php endif; ?>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm">
        <thead class="border bg-gray-200/80 text-gray-600 text-left">
            <tr>
                <th class="p-4"><input type="checkbox" class="accent-indigo-600"></th>
                <th class="p-4">Tên thương hiệu</th>
                <th class="p-4">Slug</th>
                <th class="p-4">Mô tả</th>
                <th class="p-4">Trạng thái</th>
                <th class="p-4">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($data as $brand): ?>
                <tr class="hover:bg-gray-50 border border-b">
                    <td class="p-4"><input type="checkbox" class="accent-indigo-600"></td>
                    <td class="p-4 flex items-center gap-3">
                        <img src="<?= !empty($brand['logoUrl']) ? BASE_ASSETS_UPLOADS . $brand['logoUrl'] : BASE_ASSETS_UPLOADS . 'brands/placehold.png' ?>"
                            class="w-10 h-10 rounded-full" alt="">
                        <div>
                            <p class="font-medium text-gray-700"><?= $brand['title'] ?></p>
                            <p class="text-xs text-gray-400">ID: <?= $brand['id'] ?></p>
                        </div>
                    </td>
                    <td class="p-4 text-gray-600"><?= $brand['slug'] ?></td>
                    <td class="p-4 text-gray-600"><?= $brand['description'] ?></td>
                    <td class="p-4">
                        <span
                            class="inline-block px-2 py-1 rounded-full text-xs font-medium 
                            <?= $brand['isActive'] == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                            <?= $brand['isActive'] ? 'Đang hoạt động' : 'Ngừng hoạt động' ?>
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="<?= BASE_URL_ADMIN . '&action=brands-show&id=' . $brand['id'] ?>"
                                class="group no-underline w-8 h-8 flex items-center justify-center rounded transition-all duration-200  hover:bg-slate-100">
                                <i class="fa-regular fa-eye text-slate-500 group-hover:text-blue-400"></i>
                            </a>
                            <a href="<?= BASE_URL_ADMIN . '&action=brands-edit&id=' . $brand['id'] ?>"
                                class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100">
                                <i class="fas fa-edit text-slate-500 group-hover:text-yellow-500"></i>
                            </a>
                            <?php if ($brand['isActive'] == 1): ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=brands-softDelete&id=' . $brand['id'] ?>"
                                    onclick="return confirm('Có chắc xóa không?')"
                                    class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100">
                                    <i class="fas fa-trash text-slate-500 group-hover:text-red-500"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=brands-restore&id=' . $brand['id'] ?>"
                                    onclick="return confirm('Có chắc khôi phục không?')"
                                    class="px-3 py-1 text-sm rounded bg-green-100 text-green-700 hover:bg-green-200">
                                    Khôi phục
                                </a>
                                <a href="<?= BASE_URL_ADMIN . '&action=brands-delete&id=' . $brand['id'] ?>"
                                    onclick="return confirm('Có chắc xóa vĩnh viễn không?')"
                                    class="px-3 py-1 text-sm rounded bg-red-100 text-red-700 hover:bg-red-200">
                                    Xóa cứng
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    a {
        text-decoration: none;
    }
</style>
