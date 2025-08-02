<div class="dashboard">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Trang quản lý tin tức</h1>
        <p class="dashboard-description">
            Danh sách tin tức, quản lý tin tức
        </p>
    </div>

    <!-- danh sách tin tức -->
    <div class="product-actions">
        <div class="product-filters">
            <div class="filter-group">
                <div class="search-container product-search">
                    <i class="fas fa-search search-icon"></i>
                    <input
                        type="search"
                        class="search-input"
                        id="productSearch"
                        placeholder="Tìm kiếm tin tức..." />
                </div>
            </div>
        </div>
        <button class="add-product-btn" id="addProductBtn">
            <a href="../news-add/news-add.html" class="link-text"><i class="fas fa-plus"></i>Thêm tin tức mới</a>
        </button>
    </div>

    <!-- Products Table -->
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
                    <th>Tên tin tức</th>
                    <th>Nội dung</th>
                    <th>Tác giả</th>
                    <th>Ngày xuất bản</th>
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
                            <div class="product-image">
                                <img
                                    src="https://via.placeholder.com/40"
                                    alt="Tin tức" />
                            </div>
                            <div class="product-details">
                                <p class="product-name">tin tức 1</p>
                                <p class="product-id">ID: #PRD001</p>
                            </div>
                        </div>
                    </td>
                    <td>Nội dung 1</td>
                    <td>Tác giả 1</td>
                    <td>24/07/2025</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" data-id="1">
                                <a href="../news-edit/news-edit.html"><i class="fas fa-edit"></i></a>
                            </button>
                            <button class="action-btn delete-btn" data-id="1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="product2" />
                            <label for="product2"></label>
                        </div>
                    </td>
                    <td>
                        <div class="product-info">
                            <div class="product-image">
                                <img
                                    src="https://via.placeholder.com/40"
                                    alt="Product 2" />
                            </div>
                            <div class="product-details">
                                <p class="product-name">tin tức 2</p>
                                <p class="product-id">ID: #PRD002</p>
                            </div>
                        </div>
                    </td>
                    <td>Nội dung 1</td>
                    <td>Tác giả 2</td>
                    <td>24/07/2025</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" data-id="2">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="product3" />
                            <label for="product3"></label>
                        </div>
                    </td>
                    <td>
                        <div class="product-info">
                            <div class="product-image">
                                <img
                                    src="https://via.placeholder.com/40"
                                    alt="Product 3" />
                            </div>
                            <div class="product-details">
                                <p class="product-name">tin tức 3</p>
                                <p class="product-id">ID: #PRD003</p>
                            </div>
                        </div>
                    </td>
                    <td>Nội dung 1</td>
                    <td>Tác giả 3</td>
                    <td>24/07/2025</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" data-id="3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="3">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="product4" />
                            <label for="product4"></label>
                        </div>
                    </td>
                    <td>
                        <div class="product-info">
                            <div class="product-image">
                                <img
                                    src="https://via.placeholder.com/40"
                                    alt="Product 4" />
                            </div>
                            <div class="product-details">
                                <p class="product-name">tin tức 4</p>
                                <p class="product-id">ID: #PRD004</p>
                            </div>
                        </div>
                    </td>
                    <td>Nội dung 1</td>
                    <td>Tác giả 4</td>
                    <td>24/07/2025</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" data-id="4">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="4">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox-container">
                            <input type="checkbox" id="product5" />
                            <label for="product5"></label>
                        </div>
                    </td>
                    <td>
                        <div class="product-info">
                            <div class="product-image">
                                <img
                                    src="https://via.placeholder.com/40"
                                    alt="Product 5" />
                            </div>
                            <div class="product-details">
                                <p class="product-name">tin tức 5</p>
                                <p class="product-id">ID: #PRD005</p>
                            </div>
                        </div>
                    </td>
                    <td>Nội dung 1</td>
                    <td>Tác giả 5</td>
                    <td>24/07/2025</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn edit-btn" data-id="5">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="5">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--phân trang  -->
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