<a href="<?= BASE_URL_ADMIN . '&action=users-create' ?>" class="btn btn-primary mb-3">Them moi</a>

<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';

    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";

    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<div class="user-actions">
    <div class="user-filters">
        <div class="filter-group">
            <select class="filter-select" id="roleFilter">
                <option value="">Tất cả vai trò</option>
                <option value="admin">Vai trò 1</option>
                <option value="editor">Vai trò 2</option>
                <option value="user">Vai trò 3</option>
            </select>
        </div>
        <div class="filter-group">
            <select class="filter-select" id="statusFilter">
                <option value="">Tất cả trạng thái</option>
                <option value="active">Hoạt động</option>
                <option value="inactive">Không hoạt động</option>
                <option value="pending">Đang bị khoá</option>
            </select>
        </div>
        <div class="filter-group">
            <div class="search-container user-search">
                <i class="fas fa-search search-icon"></i>
                <input type="search" class="search-input" id="userSearch" placeholder="Tìm kiếm người dùng..." />
            </div>
        </div>
    </div>
    <a href="../user-add/user-add.html" class="add-user-btn">
        <i class="fas fa-plus"></i>Thêm người dùng mới
    </a>
</div>

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
        <?php foreach ($data as $user): ?>
            <tr>
                <td>
                    <div class="checkbox-container">
                        <input type="checkbox" id="<?= $user['id'] ?>" />
                        <label for="<?= $user['id'] ?>"></label>
                </td>
                <td>
                    <div class="user-info-cell">
                        <div class="user-avatar">
                            <?php if (!empty($user['avatarUrl'])): ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . $user['avatarUrl'] ?>" alt="" width="100px">
                            <?php else: ?>
                                <img src="<?= BASE_ASSETS_UPLOADS . 'users/placehold.png' ?>" alt="" width="100px">
                            <?php endif ?>
                        </div>
                        <div class="user-details">
                            <p class="user-name"><?= $user['fullname'] ?></p>
                            <p class="user-id">ID: <?= $user['id'] ?></p>
                        </div>
                    </div>
                </td>
                <td><?= $user['email'] ?></td>
                <td><span
                        class="role-badge <?= $user['role'] == 0 ? 'user' : ($user['role'] == 1 ? 'admin' : 'editor') ?> "><?= $user['role'] == 0 ? 'user' : ($user['role'] == 1 ? 'admin' : 'editor') ?></span>
                </td>
                <td><span
                        class="status-badge <?= $user['isActive'] == 1 ? 'active' : 'inactive' ?>"><?= $user['isActive'] == 1 ? 'active' : 'inactive' ?></span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="../user-edit/user-edit.html" class="action-btn edit-btn" data-id="1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="action-btn delete-btn" data-id="1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
                <td>
                    <a href="<?= BASE_URL_ADMIN . '&action=users-show&id=' . $user['id'] ?>" class="btn btn-info">Xem chi
                        tiet</a>
                    <a href="<?= BASE_URL_ADMIN . '&action=users-edit&id=' . $user['id'] ?>"
                        class="btn btn-warning ms-3 me-3">Sua</a>
                    <a href="<?= BASE_URL_ADMIN . '&action=users-delete&id=' . $user['id'] ?>"
                        onclick="return confirm('co chac xoa khong?')" class="btn btn-danger">Xoa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td>
                <div class="checkbox-container">
                    <input type="checkbox" id="user1" />
                    <label for="user1"></label>
                </div>
            </td>
            <td>
                <div class="user-info-cell">
                    <div class="user-avatar">
                        <img src="https://via.placeholder.com/40" alt="User 1" />
                    </div>
                    <div class="user-details">
                        <p class="user-name">Người dùng 1</p>
                        <p class="user-id">ID: #USR001</p>
                    </div>
                </div>
            </td>
            <td>user@gmail.com</td>
            <td><span class="role-badge admin">Vai trò 1</span></td>
            <td><span class="status-badge active">Hoạt động</span></td>
            <td>2023-04-15 10:30 AM</td>
            <td>
                <div class="action-buttons">
                    <a href="../user-edit/user-edit.html" class="action-btn edit-btn" data-id="1">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="action-btn delete-btn" data-id="1">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    </table>
</div>