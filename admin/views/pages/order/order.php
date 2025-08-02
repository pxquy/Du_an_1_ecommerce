        <div class="dashboard">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Trang quản lý đơn hàng</h1>
                <p class="dashboard-description">
                    Danh sách đơn hàng, quản lý đơn hàng
                </p>
            </div>

            <!-- Lọc đơn hàng -->
            <div class="product-actions">
                <div class="product-filters">
                    <div class="filter-group">
                        <label for="date">Ngày bắt đầu</label>
                        <input type="date" id="date" class="filter-select" />
                    </div>
                    <div class="filter-group">
                        <label for="date">Ngày kết thúc</label>
                        <input type="date" id="date" class="filter-select" />
                    </div>
                    <div class="filter-group">
                        <label for="statusFilter">Trạng thái</label>
                        <select class="filter-select" id="statusFilter">
                            <option value="">Tất cả trạng thái</option>
                            <option value="in-stock">Còn hàng</option>
                            <option value="low-stock">Ít hàng</option>
                            <option value="out-of-stock">Hết hàng</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="productSearch">Họ và tên</label>
                        <div class="search-container product-search">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="search"
                                class="search-input"
                                id="productSearch"
                                placeholder="Họ và tên..." />
                        </div>
                    </div>
                </div>
                <button class="add-product-btn" id="addProductBtn">
                    <i class="fas fa-filter"></i>Lọc
                </button>
            </div>

            <!-- Danh sách đơn hàng -->
            <div class="table-container">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="selectAll" />
                                    <label for="selectAll"></label>
                                </div>
                            </th>
                            <th>Tên người dùng</th>
                            <th>Địa chỉ nhận hàng</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th>Mã giảm giá</th>
                            <th>Số tiền phải trả</th>
                            <th>Miễn ship</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="product1" />
                                    <label for="product1"></label>
                                </div>
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-details">
                                        <p class="product-name">Đơn hàng 1</p>
                                        <p class="product-id">ID: #PRD001</p>
                                    </div>
                                </div>
                            </td>
                            <td>Hà Nội</td>
                            <td>Hàng dễ vỡ</td>
                            <td><span class="status-badge in-stock">Chờ xử lý</span></td>
                            <td>AAA55</td>
                            <td>10000$</td>
                            <td>Miễn ship</td>
                            <td>9000$</td>
                            <td>Thanh toán khi nhận hàng</td>
                            <td><span class="status-badge in-stock">Đang xử lý</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" data-id="1">
                                        <a href="../order-edit/order-edit.html"><i class="fas fa-edit"></i></a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="product1" />
                                    <label for="product1"></label>
                                </div>
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-details">
                                        <p class="product-name">Đơn hàng 1</p>
                                        <p class="product-id">ID: #PRD001</p>
                                    </div>
                                </div>
                            </td>
                            <td>Hà Nội</td>
                            <td>Hàng dễ vỡ</td>
                            <td><span class="status-badge in-stock">Chờ xử lý</span></td>
                            <td>AAA55</td>
                            <td>10000$</td>
                            <td>Miễn ship</td>
                            <td>9000$</td>
                            <td>Thanh toán khi nhận hàng</td>
                            <td><span class="status-badge in-stock">Đang xử lý</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" data-id="1">
                                        <a href="../products-edit/products-edit.html"><i class="fas fa-edit"></i></a>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="product1" />
                                    <label for="product1"></label>
                                </div>
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-details">
                                        <p class="product-name">Đơn hàng 1</p>
                                        <p class="product-id">ID: #PRD001</p>
                                    </div>
                                </div>
                            </td>
                            <td>Hà Nội</td>
                            <td>Hàng dễ vỡ</td>
                            <td><span class="status-badge in-stock">Chờ xử lý</span></td>
                            <td>AAA55</td>
                            <td>10000$</td>
                            <td>Miễn ship</td>
                            <td>9000$</td>
                            <td>Thanh toán khi nhận hàng</td>
                            <td><span class="status-badge in-stock">Đang xử lý</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn" data-id="1">
                                        <a href="../products-edit/products-edit.html"><i class="fas fa-edit"></i></a>
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