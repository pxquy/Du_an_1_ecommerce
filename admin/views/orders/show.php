<div class="bg-white rounded p-4 mb-3 mt-3">
    <h2 class="text-uppercase">đơn hàng <?= $order['id'] ?></h2>
    <p><strong>Khách hàng:</strong> <span
            class="font-bold text-uppercase text-lg"><?= $order['fullName'] ?? 'N/A' ?></span>
    </p>
    <p><strong>Trạng thái:</strong>
        <?php if ($order['status'] != 4): ?>
        <form method="post" action="<?= BASE_URL_ADMIN ?>&action=orders-updateStatus"
            onsubmit="return confirm('Xác nhận cập nhật trạng thái?')">
            <input type="hidden" name="id" value="<?= $order['id'] ?>">

            <select name="status" class="form-select w-auto d-inline-block">
                <option value="1" <?= $order['status'] == '1' ? 'selected' : '' ?>>Chờ xác nhận</option>
                <option value="2" <?= $order['status'] == '2' ? 'selected' : '' ?>>Đang xử lý</option>
                <option value="3" <?= $order['status'] == '3' ? 'selected' : '' ?>>Đang giao hàng</option>
                <option value="4">Thành công</option>
                <option value="5" <?= $order['status'] == '5' ? 'selected' : '' ?>>Hủy</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
        </form>
    <?php else: ?>
        <span class="inline-block px-2 py-1 rounded-full font-medium 
                                bg-green-100 text-green-800">Thành công</span>
    <?php endif ?>
    </p>
</div>

<div class="bg-white p-4">
    <h4>Sản phẩm trong đơn</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $item): ?>
                <tr>
                    <td><?= $item['title'] ?? 'N/A' ?></td>
                    <td><?= $item['value'] ?></td>
                    <td><?= number_format($item['price']) ?>đ</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>