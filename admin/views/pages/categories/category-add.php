<div class="dashboard">
    <div class="dashboard-header">
        <div class="breadcrumb">
            <a
                href="../category-list/category-list.html"
                class="breadcrumb-link">Danh mục</a>
            <i class="fas fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current">Trang thêm danh mục mới</span>
        </div>
        <h1 class="dashboard-title">Trang thêm danh mục mới</h1>
        <p class="dashboard-description">Thêm thông tin danh mục.</p>
    </div>

    <!-- thêm danh mục -->
    <div class="user-form-container">
        <form id="userForm" class="user-form">


            <div class="form-card">
                <h2 class="form-card-title">Chi tiết danh mục</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Tên danh mục*</label>
                        <input
                            type="text"
                            id="username"
                            class="form-input"
                            placeholder="Nhập tên danh mục..."
                            required />
                    </div>
                    <div class="form-group">
                        <label for="password">Mô tả*</label>
                        <textarea
                            type="text"
                            id="text"
                            class="form-input"
                            placeholder="Nhập mô tả..."
                            required>
                    </textarea>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h2 class="form-card-title">Hình ảnh</h2>
                <div class="form-group">
                    <label for="userAvatar">Hình ảnh</label>
                    <div class="file-input-container">
                        <input
                            type="file"
                            id="userAvatar"
                            class="file-input"
                            accept="image/*" />
                        <label for="userAvatar" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i> Choose Image
                        </label>
                        <span class="file-name" id="fileName">No file chosen</span>
                    </div>
                    <div
                        class="avatar-preview-container"
                        id="avatarPreviewContainer">
                    </div>
                </div>
                <div class="form-group">
                    <label for="bio">Mô tả</label>
                    <textarea
                        id="bio"
                        class="form-textarea"
                        placeholder="Mô tả danh mục..."
                        rows="4"></textarea>
                </div>
            </div>

            <div class="form-card">
                <h2 class="form-card-title">Cài đặt</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Trạng thái*</label>
                        <select id="status" class="form-select" required>
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                            <option value="pending">Đang bị khoá</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="../category-list/category-list.html" class="btn-cancel">Quay lại</a>
                <button type="submit" class="btn-save">Lưu danh mục</button>
            </div>
        </form>
    </div>
</div>