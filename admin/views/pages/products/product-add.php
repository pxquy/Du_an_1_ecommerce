        <div class="dashboard">
            <div class="dashboard-header">
                <div class="breadcrumb">
                    <a href="product-manager.html" class="breadcrumb-link">Sản phẩm</a>
                    <i class="fas fa-chevron-right breadcrumb-separator"></i>
                    <span class="breadcrumb-current">Thêm sản phẩm mới</span>
                </div>
                <h1 class="dashboard-title">Trang thêm sản phẩm</h1>
                <p class="dashboard-description">
                    Thêm thông tin sản phẩm mới của bạn
                </p>
            </div>

            <!-- Thêm sản phẩm -->
            <div class="product-form-container">
                <form id="productForm" class="product-form">
                    <div class="form-card">
                        <h2 class="form-card-title">Thông tin cơ bản</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productName">Tên sản phẩm*</label>
                                <input
                                    type="text"
                                    id="productName"
                                    class="form-input"
                                    placeholder="Nhập tên sản phẩm..."
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="productSKU">Mã sản phẩm*</label>
                                <input
                                    type="text"
                                    id="productSKU"
                                    class="form-input"
                                    placeholder="Nhập mã sản phẩm..."
                                    required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Mô tả sản phẩm</label>
                            <textarea
                                id="productDescription"
                                class="form-textarea"
                                placeholder="Nhập mô tả..."
                                rows="4"></textarea>
                        </div>
                    </div>

                    <div class="form-card">
                        <h2 class="form-card-title">Giá và hàng tồn kho</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productPrice">Giá*</label>
                                <input
                                    type="number"
                                    id="productPrice"
                                    class="form-input"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productStock">Số lượng tồn kho*</label>
                                <input
                                    type="number"
                                    id="productStock"
                                    class="form-input"
                                    placeholder="0"
                                    min="0"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="productStatus">Trạng thái sản phẩm*</label>
                                <select id="productStatus" class="form-select" required>
                                    <option value="in-stock">Còn hàng</option>
                                    <option value="low-stock">Ít hàng</option>
                                    <option value="out-of-stock">Hết hàng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <h2 class="form-card-title">Tổ chức</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productCategory">Danh mục*</label>
                                <select id="productCategory" class="form-select" required>
                                    <option value="" hidden>Chọn danh mục sản phẩm</option>
                                    <option value="electronics">Danh mục 1</option>
                                    <option value="clothing">Danh mục 2</option>
                                    <option value="home">Danh mục 3</option>
                                    <option value="books">Danh mục 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productTags">Thẻ*</label>
                                <input
                                    type="text"
                                    id="productTags"
                                    class="form-input"
                                    placeholder="sản phẩm hot" />
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <h2 class="form-card-title">Hình ảnh</h2>
                        <div class="form-group">
                            <label for="productImage">Ảnh sản phẩm</label>
                            <div class="file-input-container">
                                <input
                                    type="file"
                                    id="productImage"
                                    class="file-input"
                                    accept="image/*"
                                    multiple />
                                <label for="productImage" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i> Choose Images
                                </label>
                                <span class="file-name" id="fileName">No files chosen</span>
                            </div>
                            <div
                                class="image-preview-container"
                                id="imagePreviewContainer">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="../products-list/products.html" class="btn-cancel">Quay lại</a>
                        <button type="submit" class="btn-save">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>