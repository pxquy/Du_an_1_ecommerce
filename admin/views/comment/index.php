<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>

<!-- Bộ lọc và hành động -->
<div class="user-actions d-flex align-items-center justify-content-between gap-4 mb-3">
    <div class="d-flex flex-row align-items-center gap-3 flex-grow-1">
        <select class="filter-select" id="roleFilter">
            <option value="">Tất cả vai trò</option>
            <option value="0">Nhân viên</option>
            <option value="1">Quản lý</option>
            <option value="2">Khách hàng</option>
        </select>

        <select class="filter-select" id="statusFilter">
            <option value="">Tất cả trạng thái</option>
            <option value="1">Hoạt động</option>
            <option value="0">Không hoạt động</option>
        </select>

        <div class="search-container user-search">
            <i class="fas fa-search search-icon"></i>
            <input type="search" class="search-input" id="userSearch" placeholder="Tìm kiếm người dùng..." />
        </div>
    </div>

    <button id="deleteSelected" class="btn btn-danger">Xoá đã chọn</button>

    <a href="<?= BASE_URL_ADMIN . '&action=users-create' ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm người dùng mới
    </a>
</div>

<!-- Bảng người dùng -->
<div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>
                    <div class="checkbox-container">
                        <input type="checkbox" id="selectAll" />
                        <label for="selectAll"></label>
                    </div>
                </th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Phân trang -->
<div id="pagination" class="mt-3 flex gap-2"></div>

<!-- SCRIPT AJAX -->
<script>
    const PATH = '<?= rtrim(BASE_ASSETS_UPLOADS, "/") ?>/';
    const BASE = '<?= BASE_URL_ADMIN ?>';
    let currentPage = 1;

    function loadComment(page = 1) {
        const role = document.getElementById('roleFilter').value;
        const status = document.getElementById('statusFilter').value;
        const search = document.getElementById('userSearch').value;

        const params = new URLSearchParams({ ajax: 1, page, role, status, search });

        fetch(`${BASE}&action=users-index&${params}`)
            .then(res => res.json())
            .then(res => {
                renderUserTable(res.data);
                renderPagination(res.total, res.page, res.perPage);
            });
    }

    // console.log(data);

    function renderUserTable(users) {
        const rows = users.map(user => {
            const avatar = user.avatarUrl ? `${PATH}${user.avatarUrl}` : `${PATH}users/placehold.png`;
            const roleLabel = user.role == 0 ? 'Nhân viên' : (user.role == 1 ? 'Quản lý' : 'Khách hàng');
            const roleClass = user.role == 0 ? 'user' : (user.role == 1 ? 'admin' : 'editor');
            const statusLabel = user.isActive == 1 ? 'active' : 'inactive';
            const statusClass = user.isActive == 1 ? 'active' : 'inactive';

            return `
        <tr class="k">
            <td>
                <div class="checkbox-container">
                    <input type="checkbox" class="user-checkbox" value="${user.id}" />
                    <label for="${user.id}"></label>
                </div>
            </td>
            <td>
                <div class="user-info-cell">
                    <div class="user-avatar">
                        <img src="${avatar}" alt="" width="100px">
                    </div>
                    <div class="user-details">
                        <p class="user-name">${user.fullname}</p>
                        <p class="user-id">ID: ${user.id}</p>
                    </div>
                </div>
            </td>
            <td>${user.email}</td>
            <td><span class="role-badge ${roleClass}">${roleLabel}</span></td>
            <td><span class="status-badge ${statusClass}">${statusLabel}</span></td>
            <td>
                <div class="action-buttons">
                    <a href="${BASE}&action=users-show&id=${user.id}" class="action-btn edit-btn" title="Xem chi tiết">
                        <i class="fa-regular fa-calendar"></i>
                    </a>
                    <a href="${BASE}&action=users-edit&id=${user.id}" class="action-btn edit-btn" title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                    </a>
                    ${user.isActive == 1
                    ? `<a href="${BASE}&action=users-softDelete&id=${user.id}" class="action-btn delete-btn" title="Xóa mềm" onclick="return confirm('Bạn có chắc chắn muốn xóa mềm người dùng này không?')">
                                <i class="fas fa-trash"></i>
                            </a>`
                    : `<a href="${BASE}&action=users-restore&id=${user.id}" class="action-btn restore-btn" title="Khôi phục" onclick="return confirm('Bạn có chắc chắn muốn khôi phục người dùng này không?')">
                                <i class="fas fa-rotate-left"></i>
                            </a>`}
                </div>
            </td>
        </tr>
        `;
        }).join('');

        const newTbody = document.createElement('tbody');
        newTbody.innerHTML = rows;
        const oldTbody = document.querySelector('.users-table tbody');
        if (oldTbody) oldTbody.remove();
        document.querySelector('.users-table').appendChild(newTbody);

        document.getElementById('selectAll')?.addEventListener('change', function () {
            document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }

    function renderPagination(total, page, perPage) {
        const totalPages = Math.ceil(total / perPage);
        let html = '';
        for (let i = 1; i <= totalPages; i++) {
            html += `<button onclick="loadUsers(${i})" class="${i === +page ? 'bg-indigo-500 text-white' : 'bg-white'} px-2 py-1 border rounded">${i}</button>`;
        }
        document.getElementById('pagination').innerHTML = html;
    }

    function deleteSelectedUsers() {
        const ids = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
        if (ids.length === 0) return alert('Vui lòng chọn người dùng cần xóa');
        if (!confirm(`Bạn có chắc muốn xóa mềm ${ids.length} người dùng đã chọn?`)) return;

        fetch(`${BASE}&action=users-softDeleteMany`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ids })
        })
            .then(res => res.json())
            .then(res => {
                alert(res.message || 'Xóa mềm thành công');
                loadUsers(currentPage);
            });
    }

    ['userSearch', 'roleFilter', 'statusFilter'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => loadUsers(1));
    });

    document.getElementById('deleteSelected').addEventListener('click', deleteSelectedUsers);
    document.addEventListener('DOMContentLoaded', () => loadUsers());
</script>