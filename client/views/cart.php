<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f8f8f8;
    }

    img {
        max-width: 60px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .total-row {
        font-weight: bold;
        background-color: #fafafa;
    }

    .empty-cart {
        text-align: center;
        padding: 30px;
        font-size: 18px;
        color: #777;
    }

    .msg {
        margin-bottom: 15px;
        padding: 8px;
        border-radius: 5px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
    </style>
</head>

<body>

    <h2>🛒 Giỏ hàng của bạn</h2>

    <?php if (!empty($_SESSION['msg'])): ?>
    <div class="msg <?= $_SESSION['success'] ? 'success' : 'error' ?>">
        <?= htmlspecialchars($_SESSION['msg']);
            unset($_SESSION['msg'], $_SESSION['success']); ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>
    <table>
        <thead>
            <tr>
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
            <?php
                $total = 0;
                foreach ($cartItems as $index => $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td>
                    <?php if (!empty($item['image'])): ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Ảnh sản phẩm">
                    <?php else: ?>
                    <span>Không có ảnh</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= htmlspecialchars($item['variantAttributes'] ?: '-') ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">Tổng cộng:</td>
                <td><?= number_format($total, 0, ',', '.') ?> đ</td>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <p class="empty-cart">Giỏ hàng của bạn hiện đang trống.</p>
    <?php endif; ?>

</body>

</html>