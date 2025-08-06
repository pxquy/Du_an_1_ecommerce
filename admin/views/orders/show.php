<h2>Chi tiết đơn hàng #<?= $order['id'] ?></h2>
<p><strong>Khách hàng:</strong> <?= $order['customerName'] ?? 'N/A' ?></p>
<p><strong>Trạng thái:</strong>
<form method="post" action="<?= BASE_URL_ADMIN ?>&action=orders-updateStatus"
    onsubmit="return confirm('Xác nhận cập nhật trạng thái?')">
    <input type="hidden" name="id" value="<?= $order['id'] ?>">
    <select name="status" class="form-select w-auto d-inline-block">
        <?php foreach (['pending', 'processing', 'completed', 'cancelled'] as $st): ?>
            <option value="<?= $st ?>" <?= $order['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
</form>
</p>
<h4>Sản phẩm trong đơn</h4>
<table class="table">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $item): ?>
            <tr>
                <td><?= $item['productTitle'] ?? 'N/A' ?></td>
                <td><?= number_format($item['price']) ?>đ</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>