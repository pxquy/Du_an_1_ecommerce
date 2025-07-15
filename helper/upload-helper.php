<?php
function uploadImage($file, $uploadDir)
{
    // $uploadDir = '../../Upload/';

    // 3 biến này để trả về kết quả của hàm
    $status = false; // trạng thái upload file
    $mgs = ""; // thông báo
    $payload = []; //file
    // Kiểm tra xem người dùng đã chọn file ảnh để upload hay chưa
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {

        // Lấy thông tin về file
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmp = $file['tmp_name'];

        // Kiểm tra định dạng file (chỉ cho phép các định dạng ảnh)
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowedFormats)) {
            $mgs = "Chỉ cho phép upload các file ảnh có định dạng JPG, JPEG, PNG, GIF, WEBP.";
            array_push($payload, $mgs);
            array_push($payload, $status);
            return $payload;
        }

        // Kiểm tra kích thước file (giới hạn 5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        if ($fileSize > $maxFileSize) {
            $mgs = "Kích thước file vượt quá giới hạn cho phép (5MB).";
            array_push($payload, $mgs);
            array_push($payload, $status);
            return $payload;
        }

        // Tạo tên file mới để tránh trùng lặp
        $newFileName = uniqid() . '.' . $fileExt;

        // Di chuyển file từ thư mục tạm sang thư mục lưu trữ
        $uploadPath = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            // File đã được upload thành công
            $mgs = "Upload thành công!";
            $status = true;
            array_push($payload, $mgs);
            array_push($payload, $status);
            array_push($payload, $newFileName);
            return $payload; // trả về một mảng gồm 3 phần tử 
        } else {
            // Lỗi khi di chuyển file
            $mgs = "Upload thất bại!";
            array_push($payload, $mgs);
            array_push($payload, $status);
            return $payload; // khi lỗi trả về một mảng gồm 2 phần tử
        }
    } else {
        // Không có file được chọn hoặc có lỗi trong quá trình upload
        $mgs = "Vui lòng chọn một file ảnh!";
        array_push($payload, $mgs);
        array_push($payload, $status);
        return $payload; // khi lỗi trả về một mảng gồm 2 phần tử
    }
}
