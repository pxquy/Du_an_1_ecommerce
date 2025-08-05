<div class="container">
    <?php
    if (isset($_SESSION['success'])) {
        $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
        echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
        unset($_SESSION['success'], $_SESSION['msg']);
    }

    if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['error'] as $value): ?>
                    <li><?= $value ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="POST" action="?action=create_order">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Thuộc tính</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0;
                foreach ($cartItems as $index => $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected[]" value="<?= $item['cartProductId'] ?>">
                        </td>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="">
                            <?php else: ?>
                                Không có ảnh
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= htmlspecialchars($item['variantAttributes'] ?: '-') ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                        <td>
                            <a href="?action=delete_cart&cartProductId=<?= $item['cartProductId'] ?>&cartId=<?= $item['cartId'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                Xóa
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit">Tạo đơn hàng</button>
    </form>

</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>