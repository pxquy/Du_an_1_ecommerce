
            <!-- Nội dung banner -->
            <div class="dashboard">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Danh sách banner</h1>
                    <p class="dashboard-description">Danh sách và quản lý banner.</p>
                </div>

                <div class="user-actions">
                    <div class="user-filters">
                        <div class="filter-group">
                            <select class="filter-select" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <select class="filter-select" id="statusFilter">
                                <option value="">Tất cả danh mục</option>
                                <option value="">danh mục 1</option>
                                <option value="">danh mục 2</option>
                                <option value="">danh mục 3</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <div class="search-container user-search">
                                <i class="fas fa-search search-icon"></i>
                                <input
                                    type="search"
                                    class="search-input"
                                    id="userSearch"
                                    placeholder="Tìm kiếm banner..." />
                            </div>
                        </div>
                    </div>
                    <a href="../banner-add/banner-add.html" class="add-user-btn">
                        <i class="fas fa-plus"></i>Thêm banner mới
                    </a>
                </div>

                <!-- Users Table -->
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
                                <th>Tên banner</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                            <img
                                                src="https://via.placeholder.com/40"
                                                alt="banner" />
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name">banner 1</p>
                                            <p class="user-id">ID: #USR001</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="category">Danh mục 1</td>
                                <td><span class="status-badge active">Hoạt động</span></td>
                                <td>Mô tả banner</td>
                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="../banner-edit/banner-edit.html"
                                            class="action-btn edit-btn"
                                            data-id="1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn" data-id="1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="user2" />
                                        <label for="user2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info-cell">
                                        <div class="user-avatar">
                                            <img
                                                src="https://via.placeholder.com/40"
                                                alt="banner" />
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name">banner 2</p>
                                            <p class="user-id">ID: #USR002</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="category">Danh mục 2</td>
                                <td><span class="status-badge active">Hoạt động</span></td>
                                <td>Mô tả banner</td>
                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="edit-user.html?id=2"
                                            class="action-btn edit-btn"
                                            data-id="2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn" data-id="2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="user3" />
                                        <label for="user3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info-cell">
                                        <div class="user-avatar">
                                            <img
                                                src="https://via.placeholder.com/40"
                                                alt="banner" />
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name">banner 3</p>
                                            <p class="user-id">ID: #USR003</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="category">Danh mục 1</td>
                                <td>
                                    <span class="status-badge inactive">Không hoạt động</span>
                                </td>
                                <td>Mô tả banner</td>
                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="edit-user.html?id=3"
                                            class="action-btn edit-btn"
                                            data-id="3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn" data-id="3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="user4" />
                                        <label for="user4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info-cell">
                                        <div class="user-avatar">
                                            <img
                                                src="https://via.placeholder.com/40"
                                                alt="banner" />
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name">banner 4</p>
                                            <p class="user-id">ID: #USR004</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="category">Danh mục 3</td>
                                <td>
                                    <span class="status-badge pending">Đang bị khoá</span>
                                </td>
                                <td>Mô tả banner</td>
                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="edit-user.html?id=4"
                                            class="action-btn edit-btn"
                                            data-id="4">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn" data-id="4">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="user5" />
                                        <label for="user5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info-cell">
                                        <div class="user-avatar">
                                            <img
                                                src="https://via.placeholder.com/40"
                                                alt="Danh mục" />
                                        </div>
                                        <div class="user-details">
                                            <p class="user-name">banner 5</p>
                                            <p class="user-id">ID: #USR005</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="category">Danh mục 2</td>
                                <td>
                                    <span class="status-badge pending">Đang bị khoá</span>
                                </td>
                                <td>Mô tả banner</td>
                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="edit-user.html?id=5"
                                            class="action-btn edit-btn"
                                            data-id="5">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn" data-id="5">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="pagination">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <span class="pagination-ellipsis">...</span>
                    <button class="pagination-btn">10</button>
                    <button class="pagination-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>