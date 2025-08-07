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

        button {
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .btn-cod {
            background-color: #007bff;
            color: white;
            margin-right: 10px;
        }

        .btn-vnpay {
            background-color: #28a745;
            color: white;
        }

        .btn-wrap {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thông tin giao hàng</h2>

        <form method="POST" id="orderForm">
            <label>Họ tên</label>
            <input type="text" name="fullName" value="<?= htmlspecialchars($user['fullname']) ?>" required>

            <label>Số điện thoại</label>
            <input type="text" name="phoneNumber" value="<?= htmlspecialchars($user['phone_number']) ?>" required>

            <label>Địa chỉ giao hàng</label>
            <input type="text" name="orderAddress" value="<?= htmlspecialchars($user['address']) ?>" required>

            <h3>Sản phẩm đã chọn:</h3>
            <ul>
                <?php foreach ($selectedItems as $item): ?>
                    <li><?= htmlspecialchars($item['title']) ?> x <?= $item['quantity'] ?>
                        (<?= number_format($item['price'], 0, ',', '.') ?>đ)</li>
                <?php endforeach; ?>
            </ul>

            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="items" value='<?= json_encode($selectedItems) ?>'>

            <div class="btn-wrap">
                <button type="submit" class="btn-cod" formaction="?action=store_order">Thanh toán khi nhận hàng</button>
            </div>
        </form>
        <form action="?action=pay_vnpay" method="POST">
            <input type="hidden" name="amount" id="selectedAmountInput" value="<?= $total ?>" />

            <button type="submit" name="redirect" class="btn btn-primary thanhtoan" data-bs-toggle="modal"
                data-bs-target="#thanhtoan">
                Thanh toán Vnpay
            </button>

        </form>

    </div>
</body>


</html>