<div class="content-header">
    <div class="breadcrumb">
        <a href="../order-list/order.html" class="breadcrumb-link">Quản lý đơn hàng</a>
        <i class="fas fa-chevron-right breadcrumb-separator"></i>
        <span class="breadcrumb-current">Chi tiết đơn hàng</span>
    </div>
    <div class="content-wrapper">
        <div class="content-text">
            <h1 class="content-title">Chi tiết đơn hàng</h1>
            <p class="content-description">Chi tiết trạng thái đơn hàng.</p>
        </div>
    </div>
</div>

<!-- Chi tiết đơn hàng-->
<div class="order-details">
    <div class="order-details-header">
        <h2>Chi tiết đơn hàng</h2>
    </div>

    <div class="order-details-content">
        <!-- Thông tin đơn hàng -->
        <div class="order-info">
            <div class="info-column">
                <h3>Thông tin đơn hàng</h3>
                <ul class="info-list">
                    <li>
                        <span>Mã đơn hàng: <strong>AAA-55</strong></span>
                    </li>
                    <li>
                        <span>Ngày đặt hàng: <strong>24/07/2025</strong></span>
                    </li>
                    <li>
                        <span>Tổng tiền: <strong>9000$</strong></span>
                    </li>
                    <li>
                        <span>Trạng thái đơn hàng: <strong>Chờ xử lý</strong></span>
                    </li>
                    <li>
                        <span>Phương thức thanh toán:
                            <strong>Thanh toán khi nhận hàng(COD)</strong></span>
                    </li>
                </ul>
            </div>

            <div class="info-column">
                <h3>Thông tin giao hàng</h3>
                <ul class="info-list">
                    <li>
                        <span>Họ tên: <strong>Phùng Xuân Quí</strong></span>
                    </li>
                    <li>
                        <span>Địa chỉ: <strong>Hà Nội</strong> </span>
                    </li>
                    <li>
                        <span>Số điện thoại: <strong>0399013389</strong></span>
                    </li>
                    <li>
                        <span>Email: <strong>phungxuanquy24741@gmail.com</strong></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="order-items">
            <h3>Sản phẩm đã đặt</h3>
            <div class="order-items-table">
                <div class="order-items-header">
                    <div class="item-product">Sản phẩm</div>
                    <div class="item-price">Đơn giá</div>
                    <div class="item-quantity">Số lượng</div>
                    <div class="item-total">Thành tiền</div>
                </div>

                <div class="order-item">
                    <div class="item-product">
                        <div class="item-image">
                            <img src="" alt="Sản phẩm" />
                        </div>
                        <div class="item-details">
                            <h4 class="item-title"></h4>
                        </div>
                    </div>
                    <div class="item-price">9000$</div>
                    <div class="item-quantity">1</div>
                    <div class="item-total">9000$</div>
                </div>
            </div>
        </div>


        <div class="order-summary">
            <div class="summary-row total-row">
                <div class="summary-label">Tổng cộng: 9000$</div>
                <div class="summary-value"></div>
            </div>
        </div>
    </div>
</div>


<div class="product-form-container">
    <form
        id="editProduct"
        method="post"
        enctype="multipart/form-data"
        class="product-form">
        <div class="form-card">
            <select class="select" name="select" id="select">
                <option value="" hidden>Trạng thái đơn hàng</option>
                <option value="">Chờ xử lý</option>
                <option value="">Đang xử lý</option>
                <option value="">Đang giao hàng</option>
                <option value="">Đã giao hàng</option>
                <option value="">Thành công</option>
                <option value="">Huỷ</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="../order-list/order.html" class="btn-cancel">Quay lại</a>
            <button type="submit" name="edit-order" class="btn-save">
                Cập nhật
            </button>
        </div>
    </form>
</div>