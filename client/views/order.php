<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo đơn hàng</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        form {
            max-width: 500px;
            margin: auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
        }

        ul {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <h2>Thông tin giao hàng</h2>

    <form method="POST" action="?action=store_order">
        <label>Họ tên</label>
        <input type="text" name="fullName" required>

        <label>Số điện thoại</label>
        <input type="text" name="phoneNumber" required>

        <label>Địa chỉ giao hàng</label>
        <textarea name="orderAddress" required></textarea>

        <h3>Sản phẩm đã chọn:</h3>
        <ul>
            <?php foreach ($selectedItems as $item): ?>
                <li><?= $item['title'] ?> x <?= $item['quantity'] ?>
                    (<?= number_format($item['price'], 0, ',', '.') ?>đ)
                </li>
            <?php endforeach; ?>
        </ul>

        <input type="hidden" name="total" value="<?= $total ?>">
        <input type="hidden" name="items" value='<?= json_encode($selectedItems) ?>'>

        <button type="submit">Xác nhận đặt hàng</button>
    </form>

</body>

</html>