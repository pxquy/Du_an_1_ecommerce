        <div class="dashboard">
            <div class="dashboard-header">
                <div class="breadcrumb">
                    <a href="../banner-list/banner-list.html" class="breadcrumb-link">banners</a>
                    <i class="fas fa-chevron-right breadcrumb-separator"></i>
                    <span class="breadcrumb-current">Trang cập nhật banner mới</span>
                </div>
                <h1 class="dashboard-title">Trang thêm banner mới</h1>
                <p class="dashboard-description">Cập nhật thông tin banner</p>
            </div>

            <!-- form sửa banner -->
            <div class="user-form-container">
                <form id="userForm" class="user-form">
                    <div class="form-card">
                        <h2 class="form-card-title">Chi tiết banner</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="username">Tên banner*</label>
                                <input
                                    type="text"
                                    id="username"
                                    class="form-input"
                                    placeholder="Nhập tên banner..."
                                    required
                                    value="Banner 1" />
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="category">Danh mục*</label>
                                    <select id="category" class="form-select" required>
                                        <option value="" hidden>Chọn danh mục</option>
                                        <option value="">Danh mục 1</option>
                                        <option value="">Danh mục 2</option>
                                        <option value="">Danh mục 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Mô tả*</label>
                                <textarea
                                    type="text"
                                    id="text"
                                    class="form-input"
                                    placeholder="Nhập mô tả..."
                                    required>
                    Mô tả banner
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
                                placeholder="Mô tả banner..."
                                rows="4">
                  Mô tả banner
                </textarea>
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
                        <a href="../banner-list/banner-list.html" class="btn-cancel">Quay lại</a>
                        <button type="submit" class="btn-save">Cập nhật banner</button>
                    </div>
                </form>
            </div>
        </div>