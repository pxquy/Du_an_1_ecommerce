<div class="container py-5">
    <h2 class="mb-4">Đơn hàng đã nhận</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Sản phẩm</th>
                <th>Biến thể</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['orderId'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['orderDate'])) ?></td>
                        <td><?= htmlspecialchars($order['productTitle']) ?></td>
                        <td><?= $order['attributes'] ?? 'Không có' ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td><?= number_format($order['price'], 0, ',', '.') ?>₫</td>
                        <td><span class="badge bg-success">Đã nhận hàng</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Chưa có đơn hàng nào được nhận.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>