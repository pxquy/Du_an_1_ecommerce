<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        .container {
            background: #fff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2,
        h3 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        ul {
            margin-top: 15px;
            padding-left: 20px;
        }

        .btn-wrap {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        button {
            flex: 1;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
        }

        .btn-cod {
            background-color: #007bff;
        }

        .btn-vnpay {
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thông tin giao hàng</h2>

        <form method="POST">
            <label>Họ tên</label>
            <input type="text" name="fullName" value="<?= htmlspecialchars($user['fullname']) ?>" required>

            <label>Số điện thoại</label>
            <input type="text" name="phoneNumber" value="<?= $user['phone_number'] ?>" required>

            <label>Địa chỉ giao hàng</label>
            <input type="text" name="orderAddress" value="<?= htmlspecialchars($user['address']) ?>" required>

            <h3>Sản phẩm đã chọn:</h3>
            <ul>
                <?php foreach ($selectedItems as $item): ?>
                    <li><?= htmlspecialchars($item['title']) ?> x <?= $item['quantity'] ?>
                        (<?= number_format($item['price'], 0, ',', '.') ?>đ)</li>
                <?php endforeach; ?>
            </ul>

            <!-- Dữ liệu ẩn -->
            <input type="hidden" name="amount" value="<?= $total ?>">
            <input type="hidden" name="items" value='<?= json_encode($selectedItems) ?>'>

            <div class="btn-wrap">
                <button type="submit" class="btn-cod" formaction="?action=store_order">Thanh toán COD</button>
                <button type="submit" class="btn-vnpay" formaction="?action=pay_vnpay" name="redirect">
                    Thanh toán VNPay
                </button>
            </div>
        </form>
    </div>
</body>

</html>