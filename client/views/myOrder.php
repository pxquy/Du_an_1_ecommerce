<h2 class="text-center my-4 text-uppercase">Lịch sử đơn hàng</h2>

<?php if (empty($orders)): ?>
    <p class="text-center">Bạn chưa có đơn hàng nào.</p>
<?php else: ?>
    <table class="table table-bordered table-hover" border="1">
        <thead class="table-dark">
            <tr>
                <th>Mã Đơn</th>
                <th>Ngày đặt</th>
                <th>Sản phẩm</th>
                <th>Thuộc tính</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['orderId'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($order['orderDate'])) ?></td>
                    <td><?= $order['productTitle'] ?></td>
                    <td><?= $order['attributes'] ?? '(Không có)' ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= number_format($order['price']) ?>₫</td>
                    <td>
                        <?= match ($order['status']) {
                            '0' => 'Đã huỷ',
                            '1' => 'Chờ xác nhận',
                            '2' => 'Đang xử lý',
                            '3' => 'Đang giao',
                            '4' => 'Đã giao',
                            '5' => 'Đã nhận hàng',
                            default => 'Không xác định'
                        } ?>

                    </td>

                    <td>
                        <?php
                        if (in_array($order['status'], [1, 2])) {
                            echo '<a href="' . BASE_URL . '?action=cancel_order&id=' . $order['orderId'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn huỷ đơn hàng này?\')">Huỷ</a>';
                        } else {
                            echo '<span class="text-muted">Không thể huỷ</span>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>