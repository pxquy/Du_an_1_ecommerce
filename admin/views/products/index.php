<!-- Bộ lọc & hành động -->
<div class="d-flex align-items-center justify-content-between gap-4 mb-3">
    <div class="d-flex flex-row align-items-center gap-3 flex-grow-1">
        <!-- Select danh mục -->
        <select class="form-select" id="filterCategory">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['title'] ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Select thương hiệu -->
        <select class="form-select" id="filterBrand">
            <option value="">-- Tất cả thương hiệu --</option>
            <?php foreach ($brands as $b): ?>
                <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Sắp xếp giá -->
        <select class="form-select" id="sortPrice">
            <option value="">-- Sắp xếp giá --</option>
            <option value="asc">Giá tăng dần</option>
            <option value="desc">Giá giảm dần</option>
        </select>

        <!-- Tìm kiếm -->
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm">
    </div>

    <!-- Thêm sản phẩm -->
    <a href="<?= BASE_URL_ADMIN . '&action=products-create' ?>" class="btn btn-primary">
        Thêm sản phẩm mới
    </a>
</div>

<!-- Bảng sản phẩm -->
<div id="productTable" class="overflow-x-auto bg-white rounded-lg shadow"></div>

<!-- Phân trang -->
<div id="pagination" class="mt-3 flex gap-2"></div>

<!-- SCRIPT AJAX -->
<script>
    const PATH = '<?= rtrim(BASE_ASSETS_UPLOADS, "/") ?>/';
    const BASE = '<?= BASE_URL_ADMIN ?>';
    let currentPage = 1;

    function loadProducts(page = 1) {
        currentPage = page;

        const keyword = document.getElementById('searchInput').value;
        const category = document.getElementById('filterCategory').value;
        const brand = document.getElementById('filterBrand').value;
        const sortPrice = document.getElementById('sortPrice').value;

        const params = new URLSearchParams({
            ajax: 1,
            page,
            search: keyword,
            category,
            brand,
            sort: sortPrice
        });

        fetch(`?mode=admin&action=products-index&${params}`)
            .then(res => res.json())
            .then(res => {
                renderTable(res.data, res.page, res.perPage);
                renderPagination(res.total, res.page, res.perPage);
            })
            .catch(err => {
                console.error('Lỗi khi tải sản phẩm:', err);
            });
    }

    function renderTable(products, page = 1, perPage = 10) {
        const rows = products.map((p, index) => {
            const stt = (page - 1) * perPage + index + 1;
            return `
                <tr class="hover:bg-gray-50 border border-b">
                    <td class="p-4">${stt}</td>
                    <td class="p-4 flex items-center gap-3">
                        <img src="${p.thumbnail ? PATH + p.thumbnail : PATH + 'products/placehold.png'}" class="w-10 h-10 rounded-full" />
                        <div>
                            <p class="font-medium text-gray-700">${p.title}</p>
                            <p class="text-xs text-gray-400">Mã: ${p.sku}</p>
                        </div>
                    </td>
                    <td class="p-4">${Number(p.priceDefault).toLocaleString('vi-VN')}đ</td>
                    <td class="p-4">${p.averageRating ?? 0}</td>
                    <td class="p-4">${p.stockTotal ?? 0}</td>
                    <td class="p-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium ${p.isActive == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${p.isActive == 1 ? 'Đang bán' : 'Ngừng bán'}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="${BASE}&action=products-show&id=${p.id}" class="group text-decoration-none w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100" title="Chi tiết">
                                <i class="fa-regular fa-eye text-slate-500 group-hover:text-blue-400"></i>
                            </a>
                            <a href="${BASE}&action=products-edit&id=${p.id}" class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100" title="Sửa">
                                <i class="fas fa-edit text-slate-500 group-hover:text-yellow-500"></i>
                            </a>
                            ${p.isActive == 1
                    ? `<a href="${BASE}&action=products-softDelete&id=${p.id}" onclick="return confirm('Xoá sản phẩm này?')" class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100" title="Xoá">
                                        <i class="fas fa-trash text-slate-500 group-hover:text-red-500"></i>
                                    </a>`
                    : `<a href="${BASE}&action=products-restore&id=${p.id}" onclick="return confirm('Khôi phục sản phẩm này?')" class="group text-decoration-none w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100" title="Khôi phục">
                                        <i class="fas fa-undo text-green-600 group-hover:text-green-700"></i>
                                    </a>`
                }
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        document.getElementById('productTable').innerHTML = `
            <table class="min-w-full text-sm">
                <thead class="border bg-gray-200/80 text-gray-600 text-left">
                    <tr>
                        <th class="p-4">STT</th>
                        <th class="p-4">Tên sản phẩm</th>
                        <th class="p-4">Giá</th>
                        <th class="p-4">Đánh giá</th>
                        <th class="p-4">Kho</th>
                        <th class="p-4">Trạng thái</th>
                        <th class="p-4">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">${rows}</tbody>
            </table>
        `;
    }

    function renderPagination(total, page, perPage) {
        total = parseInt(total) || 0;
        perPage = parseInt(perPage) || 10;
        const totalPages = Math.ceil(total / perPage);

        let html = '';
        for (let i = 1; i <= totalPages; i++) {
            html += `<button onclick="loadProducts(${i})" class="${i === +page ? 'bg-indigo-500 text-white' : 'bg-white'} px-2 py-1 border rounded">${i}</button>`;
        }

        document.getElementById('pagination').innerHTML = html;
    }

    // Gắn sự kiện lọc và tìm kiếm
    ['searchInput', 'filterCategory', 'filterBrand', 'sortPrice'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => loadProducts(1));
    });

    // Load sản phẩm ban đầu
    document.addEventListener('DOMContentLoaded', () => {
        loadProducts();
    });
</script>