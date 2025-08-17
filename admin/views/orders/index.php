<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<h2>Danh sách đơn hàng</h2>

<!-- Bộ lọc -->
<form id="orderFilter" class="d-flex align-items-end gap-2 mb-3" onsubmit="return false;">
    <div>
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="">-- Tất cả --</option>
            <option value="1">Chờ xác nhận</option>
            <option value="2">Đang xử lý</option>
            <option value="3">Đang giao hàng</option>
            <option value="4">Thành công</option>
            <option value="5">Huỷ</option>
        </select>
    </div>
    <div>
        <label class="form-label">Sắp xếp</label>
        <select name="sort" class="form-select">
            <option value="newest">Mới nhất</option>
            <option value="oldest">Cũ nhất</option>
        </select>
    </div>
    <div class="flex-grow-1">
        <label class="form-label">Tìm theo tên KH</label>
        <input type="text" name="keyword" class="form-control" placeholder="Nhập tên khách hàng...">
    </div>
    <div>
        <button id="btnReset" type="button" class="btn btn-secondary">Reset</button>
    </div>
</form>

<!-- Bảng -->
<table class="min-w-full text-sm">
    <thead class="border bg-gray-200/80 text-gray-600 text-left">
        <tr>
            <th class="p-4">ID</th>
            <th class="p-4">Khách hàng</th>
            <th class="p-4">Tổng tiền</th>
            <th class="p-4">Trạng thái</th>
            <th class="p-4">Ngày tạo</th>
            <th class="p-4">Hành động</th>
        </tr>
    </thead>
    <tbody class="bg-white"></tbody>
</table>

<!-- Phân trang -->
<div id="pagination" class="mt-3 d-flex gap-2"></div>

<script>
    const BASE = '<?= BASE_URL_ADMIN ?>';
    const statusText = {
        1: 'Chờ xác nhận',
        2: 'Đang xử lý',
        3: 'Đang giao hàng',
        4: 'Thành công',
        5: 'Huỷ'
    };
    let state = { page: 1, perPage: 10 };

    function badgeClass(st) {
        st = parseInt(st, 10);
        if (st === 4) return 'bg-green-100 text-green-800';
        if (st === 5) return 'bg-red-100 text-red-800';
        return 'bg-yellow-100 text-yellow-800';
    }

    function buildParams() {
        const f = document.getElementById('orderFilter');
        const p = new URLSearchParams();
        p.set('ajax', '1');
        p.set('page', state.page);
        p.set('perPage', state.perPage);

        const st = f.elements['status'].value;
        const kw = f.elements['keyword'].value.trim();
        const sort = f.elements['sort'].value;

        if (st !== '') p.set('status', st);
        if (kw) p.set('keyword', kw);
        if (sort) p.set('sort', sort);

        return p.toString();
    }

    async function loadOrders() {
        const url = `${BASE}&action=orders-index&${buildParams()}`;
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const json = await res.json();
        renderTable(json.data || []);
        renderPager(json.meta || { page: 1, totalPage: 1 });
    }

    function renderTable(rows) {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';

        rows.forEach(order => {
            const currentStatus = parseInt(order.status);
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 border border-b';

            // Nếu đơn hàng đã bị huỷ, chỉ hiển thị <span>, không cho chọn nữa
            let statusHtml = '';
            if (currentStatus === 5) {
                statusHtml = `
                <span class="inline-block px-2 py-1 rounded-full font-medium ${badgeClass(currentStatus)}">
                    ${statusText[currentStatus]}
                </span>
            `;
            } else {
                // Build status <select> excluding canceled (status 5)
                let statusOptions = '';
                Object.entries(statusText).forEach(([key, label]) => {
                    key = parseInt(key);
                    if (key >= currentStatus && key !== 5) {
                        const selected = key === currentStatus ? 'selected' : '';
                        statusOptions += `<option value="${key}" ${selected}>${label}</option>`;
                    }
                });

                statusHtml = `
                <select data-id="${order.id}" data-old="${currentStatus}" 
                    class="form-select form-select-sm status-select ${badgeClass(currentStatus)}">
                    ${statusOptions}
                </select>
            `;
            }

            tr.innerHTML = `
            <td class="p-4">${order.id}</td>
            <td class="p-4">${order.fullname ?? 'N/A'}</td>
            <td class="p-4">${Number(order.total).toLocaleString('vi-VN')}đ</td>
            <td class="p-4">${statusHtml}</td>
            <td class="p-4">${order.createdAt}</td>
            <td class="p-4">
                <div class="flex gap-2">
                    <a href="${BASE}&action=orders-show&id=${order.id}"
                        class="group text-decoration-none w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100"
                        title="Chi tiết">
                        <i class="fa-regular fa-eye text-slate-500 group-hover:text-blue-400"></i>
                    </a>
                    ${(currentStatus !== 4 && currentStatus !== 5) ? `
                        <a href="${BASE}&action=orders-softDelete&id=${order.id}"
                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')"
                           class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 hover:bg-slate-100">
                           <i class="fas fa-trash text-slate-500 group-hover:text-red-500"></i>
                        </a>` : ''}
                </div>
            </td>
        `;

            tbody.appendChild(tr);
        });
    }

    function renderPager(meta) {
        const totalPage = meta.totalPage || 1, page = meta.page || 1;
        let html = '';
        for (let i = 1; i <= totalPage; i++) {
            html += `<button onclick="goPage(${i})" class="${i === page ? 'bg-indigo-500 text-white' : 'bg-white'} px-2 py-1 border rounded">${i}</button>`;
        }
        document.getElementById('pagination').innerHTML = html;
    }

    function goPage(i) {
        state.page = i;
        loadOrders();
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadOrders();

        const f = document.getElementById('orderFilter');
        const statusSel = f.elements['status'];
        const sortSel = f.elements['sort'];
        const keywordIp = f.elements['keyword'];

        statusSel.addEventListener('change', () => { state.page = 1; loadOrders(); });
        sortSel.addEventListener('change', () => { state.page = 1; loadOrders(); });
        keywordIp.addEventListener('input', () => { state.page = 1; loadOrders(); });

        document.getElementById('btnReset')?.addEventListener('click', () => {
            f.reset();
            state.page = 1;
            loadOrders();
        });
    });

    // Bắt sự kiện cập nhật trạng thái
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('status-select')) {
            const select = e.target;
            const id = select.getAttribute('data-id');
            const newStatus = parseInt(select.value);
            const oldStatus = parseInt(select.getAttribute('data-old'));

            // Ngăn chuyển về trạng thái cũ hơn
            if (newStatus < oldStatus) {
                alert('Không thể chuyển về trạng thái trước đó!');
                select.value = oldStatus;
                return;
            }

            const confirmMsg = `Xác nhận chuyển trạng thái đơn hàng từ "${statusText[oldStatus]}" sang "${statusText[newStatus]}"?`;
            if (!confirm(confirmMsg)) {
                select.value = oldStatus;
                return;
            }

            fetch(`${BASE}&action=orders-updateStatus`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({ id, status: newStatus })
            })
                .then(res => res.json())
                .then(json => {
                    if (json.success) {
                        select.setAttribute('data-old', newStatus); // cập nhật trạng thái mới
                        loadOrders();
                    } else {
                        alert('Cập nhật thất bại: ' + (json.msg ?? ''));
                        select.value = oldStatus;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Lỗi khi cập nhật trạng thái đơn hàng.');
                    select.value = oldStatus;
                });
        }
    });

</script>