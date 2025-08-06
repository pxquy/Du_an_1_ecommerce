<a href="<?= BASE_URL_ADMIN . '&action=categories-create' ?>" class="btn btn-primary mb-3">Them moi</a>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>
<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm">
        <thead class="border bg-gray-200/80 text-gray-600 text-left">
            <tr>
                <th class="p-4 text-gray-600/70"><input type="checkbox" class="accent-indigo-600"></th>
                <th class="p-4 text-gray-600/70">Tên danh mục</th>
                <th class="p-4 text-gray-600/70">Trạng thái</th>
                <th class="p-4 text-gray-600/70">Mô tả</th>
                <th class="p-4 text-gray-600/70">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($data as $category): ?>
                <tr class="hover:bg-gray-50 border border-b">
                    <td class="p-4"><input type="checkbox" class="accent-indigo-600"></td>
                    <td class="p-4 flex items-center gap-3">
                        <?php if (!empty($category['logoUrl'])): ?>
                            <img class="w-10 h-10 rounded-full" src="<?= BASE_ASSETS_UPLOADS . $category['logoUrl'] ?>" alt="">
                        <?php else: ?>
                            <img class="w-10 h-10 rounded-full" src="<?= BASE_ASSETS_UPLOADS . 'categories/placehold.png' ?>"
                                alt="">
                        <?php endif ?>
                        <div>
                            <p class="font-medium"><?= $category['title'] ?></p>
                            <p class="text-xs text-gray-500">ID: <?= $category['id'] ?></p>
                        </div>
                    </td>
                    <td class="p-4"><span
                            class="inline-block px-2 py-1 rounded-full text-xs font-medium <?= $category['isActive'] == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?> "><?= $category['isActive'] ? 'Đang hoạt động' : 'Không hoạt động' ?></span>
                    </td>
                    <td class="p-4"><?= $category['description'] ?></td>
                    <td>
                        <div class="flex gap-2">
                            <a href="<?= BASE_URL_ADMIN . '&action=categories-show&id=' . $category['id'] ?>"
                                class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200  hover:bg-slate-100">
                                <i class="fa-regular fa-calendar text-slate-500 group-hover:text-blue-400"></i></a>
                            <a href="<?= BASE_URL_ADMIN . '&action=categories-edit&id=' . $category['id'] ?>"
                                class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 text-slate-500 hover:bg-slate-100 "><i
                                    class="fas fa-edit text-slate-500 group-hover:text-yellow-500"></i></a>
                            <?php if ($category['isActive'] == 1): ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=categories-softDelete&id=' . $category['id'] ?>"
                                    onclick="return confirm('co chac xoa khong?')"
                                    class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 text-slate-500 hover:bg-slate-100"><i
                                        class="fas fa-trash text-slate-500 group-hover:text-red-500"></i></a>
                            <?php else: ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=categories-restore&id=' . $category['id'] ?>"
                                    onclick="return confirm('co chac khoi phuc khong?')" class="btn btn-success">khôi phục</a>
                            <?php endif ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>