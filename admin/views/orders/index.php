<h2>Danh sách đơn hàng</h2>
<table class="table table-bordered mt-3 bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Quy ước trạng thái
        $statusText = [
            1 => 'Chờ xác nhận',
            2 => 'Đang xử lý',
            3 => 'Đang giao hàng',
            4 => 'Thành công',
            5 => 'Huỷ'
        ];
        ?>

        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['fullname'] ?? 'N/A' ?></td>
                <td><?= number_format($order['total']) ?>đ</td>
                <td><?= $statusText[$order['status']] ?? 'Không xác định' ?></td>
                <td><?= $order['createdAt'] ?></td>
                <td>
                    <a href="<?= BASE_URL_ADMIN . '&action=orders-show&id=' . $order['id'] ?>"
                        class="btn btn-sm btn-info">Xem</a>
                    <a href="<?= BASE_URL_ADMIN . '&action=orders-softDelete&id=' . $order['id'] ?>"
                        onclick="return confirm('Bạn có chắc chắn muốn xoá mềm đơn hàng này?')"
                        class="btn btn-sm btn-danger">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>