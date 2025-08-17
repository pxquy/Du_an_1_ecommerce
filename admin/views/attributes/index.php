<!-- admin/views/attributes/index.php (Tailwind, icon buttons, white table, tách dòng) -->
<div class="w-full px-4 py-4">
    <!-- Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <?php $ok = $_SESSION['success'];
        $msg = htmlspecialchars($_SESSION['msg'] ?? ''); ?>
        <div
            class="<?= $ok ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' ?> border rounded-md px-3 py-2 text-sm mb-4">
            <?= $msg ?>
        </div>
        <?php unset($_SESSION['success'], $_SESSION['msg']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- LEFT: Thuộc tính -->
        <div class="space-y-3">
            <h2 class="text-base font-semibold text-gray-800">Thuộc tính</h2>

            <!-- Form Thêm thuộc tính -->
            <form method="POST" action="<?= BASE_URL_ADMIN . '&action=attributes-store' ?>"
                class="flex items-center gap-2">
                <input type="text" name="name" required placeholder="Tên thuộc tính"
                    class="w-1/2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="text" name="description" placeholder="Mô tả"
                    class="w-1/2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />

                <button type="submit"
                    class="inline-flex items-center rounded-md border border-gray-300 text-gray-700 text-sm px-3 py-2 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Thêm
                </button>
            </form>


            <!-- Bảng Thuộc tính (khung + nền trắng) -->
            <div class="border border-gray-200 rounded-xl shadow-sm overflow-hidden bg-white">
                <div class="bg-gray-50 px-3 py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-700">Danh sách thuộc tính</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm bg-white">
                        <thead class="bg-gray-50 text-gray-600 text-left">
                            <tr>
                                <th class="px-3 py-2 w-20">ID</th>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2 w-28">Action</th>
                            </tr>
                        </thead>
                        <!-- Bảng Thuộc tính -->
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($attributes as $attr): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-700"><?= $attr['id'] ?></td>
                                    <td class="px-3 py-2 text-gray-900"><?= htmlspecialchars($attr['name']) ?></td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            <?php if ($attr['isActive'] == 1): ?>
                                                <!-- Nút Xóa -->
                                                <a href="<?= BASE_URL_ADMIN . '&action=attributes-softDelete&id=' . $attr['id'] ?>"
                                                    onclick="return confirm('Xóa thuộc tính này?')"
                                                    class="inline-flex items-center justify-center rounded-md border border-gray-300 p-1.5 text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors"
                                                    aria-label="Xóa" title="Xóa">
                                                    <!-- Trash Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m-7 4v6m4-6v6M5 7h14l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7z" />
                                                    </svg>
                                                </a>
                                            <?php else: ?>
                                                <!-- Nút Khôi phục -->
                                                <a href="<?= BASE_URL_ADMIN . '&action=attributes-restore&id=' . $attr['id'] ?>"
                                                    onclick="return confirm('Khôi phục thuộc tính này?')"
                                                    class="inline-flex items-center justify-center rounded-md border border-gray-300 p-1.5 text-green-600 hover:bg-green-50 hover:text-green-800 transition-colors"
                                                    aria-label="Khôi phục" title="Khôi phục">
                                                    <!-- Refresh/Restore Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4.5 12a7.5 7.5 0 1112.62 5.12l1.62 1.63M4.5 12H2m2.5 0h2" />
                                                    </svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT: Giá trị thuộc tính -->
        <div class="space-y-3">
            <h2 class="text-base font-semibold text-gray-800">Giá trị thuộc tính</h2>

            <!-- DÒNG 1: Bộ lọc -->
            <div class="flex items-center gap-2 mb-3">
                <select id="filterAttribute"
                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">— Lọc theo thuộc tính —</option>
                    <?php foreach ($attributePluck as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="clearFilter"
                    class="inline-flex items-center rounded-md border border-gray-300 text-gray-700 text-sm px-3 py-2 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Xóa lọc
                </button>
            </div>

            <!-- DÒNG 2: Form thêm giá trị -->
            <form method="POST" action="<?= BASE_URL_ADMIN . '&action=attributeValues-store' ?>"
                class="flex items-center gap-2">
                <select name="attributeId" required
                    class="w-1/3 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <?php foreach ($attributePluck as $id => $name): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="value" required placeholder="Giá trị"
                    class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                <button type="submit"
                    class="inline-flex items-center rounded-md border border-gray-300 text-gray-700 text-sm px-3 py-2 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Thêm
                </button>
            </form>

            <!-- Bảng Giá trị (khung + nền trắng) -->
            <div class="border border-gray-200 rounded-xl shadow-sm overflow-hidden bg-white">
                <div class="bg-gray-50 px-3 py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-700">Danh sách giá trị</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm bg-white" id="valueTable">
                        <thead class="bg-gray-50 text-gray-600 text-left">
                            <tr>
                                <th class="px-3 py-2 w-20">ID</th>
                                <th class="px-3 py-2">Value</th>
                                <th class="px-3 py-2">Thuộc tính</th>
                                <th class="px-3 py-2 w-28">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($attributeValues as $v): ?>
                                <?php $attrId = $v['attributeId'];
                                $attrName = $attributePluck[$attrId] ?? '—'; ?>
                                <tr class="hover:bg-gray-50" data-attr-id="<?= (int) $attrId ?>">
                                    <td class="px-3 py-2 text-gray-700"><?= $v['id'] ?></td>
                                    <td class="px-3 py-2 text-gray-900"><?= htmlspecialchars($v['value']) ?></td>
                                    <td class="px-3 py-2 text-gray-600"><?= htmlspecialchars($attrName) ?></td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            <!-- Delete icon button -->
                                            <?php if ($v['isActive'] == 1): ?>
                                                <!-- Nút Xóa -->
                                                <a href="<?= BASE_URL_ADMIN . '&action=attributeValues-softDelete&id=' . $v['id'] ?>"
                                                    onclick="return confirm('Có chắc xóa giá trị này?')"
                                                    class="items-center justify-center rounded-md p-1.5 text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors"
                                                    aria-label="Xóa" title="Xóa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m-7 4v6m4-6v6M5 7h14l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7z" />
                                                    </svg>
                                                </a>
                                            <?php else: ?>
                                                <!-- Nút Khôi phục -->
                                                <a href="<?= BASE_URL_ADMIN . '&action=attributeValues-restore&id=' . $v['id'] ?>"
                                                    onclick="return confirm('Khôi phục giá trị này?')"
                                                    class="items-center justify-center rounded-md p-1.5 text-green-600 hover:bg-green-50 hover:text-green-800 transition-colors"
                                                    aria-label="Khôi phục" title="Khôi phục">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4.5 12a7.5 7.5 0 1112.62 5.12l1.62 1.63M4.5 12H2m2.5 0h2" />
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($attributeValues)): ?>
                                <tr>
                                    <td colspan="4" class="px-3 py-6 text-center text-gray-500">Chưa có giá trị</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS lọc client-side -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('filterAttribute');
        const clearBtn = document.getElementById('clearFilter');
        const rows = document.querySelectorAll('#valueTable tbody tr');

        function applyFilter() {
            const val = select.value;
            rows.forEach(r => {
                const attrId = r.getAttribute('data-attr-id') || '';
                r.style.display = (!val || val === attrId) ? '' : 'none';
            });
        }

        select.addEventListener('change', applyFilter);
        clearBtn.addEventListener('click', () => { select.value = ''; applyFilter(); });
    });
</script>