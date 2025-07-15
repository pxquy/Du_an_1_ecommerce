<?php

/**
 * Định dạng số tiền theo từng quốc gia cụ thể.
 *
 * @param float  $currency  Số tiền cần định dạng.
 * @param string $location  Mã quốc gia (vd: 'us', 'vn', 'eu', 'uk').
 *
 * @return string  Chuỗi tiền tệ đã định dạng.
 */
function formatCurrency($currency, $location)
{
    $formats = [
        'us' => ['symbol' => '$', 'thousand_sep' => ',', 'decimal_sep' => '.', 'decimals' => 2, 'position' => 'after'],
        'vn' => ['symbol' => '₫', 'thousand_sep' => '.', 'decimal_sep' => ',', 'decimals' => 0, 'position' => 'after'],
        'eu' => ['symbol' => '€', 'thousand_sep' => '.', 'decimal_sep' => ',', 'decimals' => 2, 'position' => 'after'],
        'uk' => ['symbol' => '£', 'thousand_sep' => ',', 'decimal_sep' => '.', 'decimals' => 2, 'position' => 'before'],
    ];

    // Mặc định là USD nếu không tìm thấy location
    $format = $formats[$location] ?? $formats['us'];

    $formattedCurrency = number_format($currency, $format['decimals'], $format['decimal_sep'], $format['thousand_sep']);

    return $format['position'] === 'before' ? $format['symbol'] . $formattedCurrency : $formattedCurrency . ' ' . $format['symbol'];
}

// Hàm hỗ trợ tính %
function calcPercent($current, $previous)
{
    if ($previous > 0) {
        return round((($current - $previous) / $previous) * 100, 1);
    }
    return $current > 0 ? 100 : 0;
}
function isIncrease($percent)
{
    return $percent >= 0;
}


function formatProductStatus($status)
{
    switch ($status) {
        case "in-stock":
            return "Còn hàng";
        case "low-stock":
            return "Tồn kho";
        case "out-of-stock":
            return "Hết hàng";
    }
}

function formatGender($gioi_tinh)
{
    switch ($gioi_tinh) {
        case 1:
            return "Nam";
        case 2:
            return "Nữ";
    }
}

function formatPaymentMethod($pttt)
{
    switch ($pttt) {
        case 1:
            return "Thanh toán khi nhận hàng (COD)";
        case 2:
            return "Chuyển khoản ngân hàng";
    }
}

function formatOrderStatus($trang_thai)
{
    switch ($trang_thai) {
        case 1:
            return "Chờ xác nhận";
        case 2:
            return "Đang xử lý";
        case 3:
            return "Đang giao hàng";
        case 4:
            return "Thành công";
        case 5:
            return "Huỷ";
    }
}


function formatClassOrderStatus($trang_thai)
{
    switch ($trang_thai) {
        case 1:
            return "confirm";
        case 2:
            return "processing";
        case 3:
            return "delivering";
        case 4:
            return "success";
        case 5:
            return 'cancel';
    }
}
