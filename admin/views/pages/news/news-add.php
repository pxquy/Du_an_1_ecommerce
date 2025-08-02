<div class="dashboard">
    <div class="dashboard-header">
        <div class="breadcrumb">
            <a href="product-manager.html" class="breadcrumb-link">Tin tức</a>
            <i class="fas fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current">Thêm tin tức mới</span>
        </div>
        <h1 class="dashboard-title">Trang thêm Tin tức</h1>
        <p class="dashboard-description">Thêm thông tin tin tức tại đây.</p>
    </div>

    <!-- Thêm tin tức mới-->
    <div class="product-form-container">
        <form id="productForm" class="product-form">
            <div class="form-card">
                <h2 class="form-card-title">Thông tin cơ bản</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="productName">Tên tin tức*</label>
                        <input
                            type="text"
                            id="productName"
                            class="form-input"
                            placeholder="Nhập tên tin tức..."
                            required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="productDescription">Nội dung*</label>
                    <textarea
                        id="productDescription"
                        class="form-textarea"
                        placeholder="Enter product description"
                        rows="4"></textarea>
                </div>
            </div>

            <div class="form-card">
                <h2 class="form-card-title">Thông tin tin tức</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="productPrice">Tác giả*</label>
                        <select name="" id="" class="select">
                            <option value="">Tác giả 1</option>
                            <option value="">Tác giả 2</option>
                            <option value="">Tác giả 3</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="productStock">Ngày xuất bản*</label>
                        <input
                            type="date"
                            id="productStock"
                            class="form-input"
                            required />
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
                <a href="../news-list/news-list.html" class="btn-cancel">Quay lại</a>
                <button type="submit" class="btn-save">Lưu tin tức</button>
            </div>
        </form>
    </div>
</div>