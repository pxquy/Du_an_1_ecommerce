<?php
if (!function_exists('debug')) {

    if (!function_exists('debug')) {
        function debug($data)
        {
            echo '<pre>';
            print_r($data);
            die;
        }
    }
    die;
}


if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetFile = $folder . '/' . time() . '-' . basename($file["name"]);
        $destination = PATH_ASSETS_UPLOADS . $targetFile;

        // Kiểm tra xem file có tồn tại không
        if (!is_uploaded_file($file["tmp_name"])) {
            throw new Exception("File không tồn tại hoặc không phải là file upload.");
        }

        // Kiểm tra đường dẫn thư mục đích có tồn tại
        if (!is_dir(PATH_ASSETS_UPLOADS . $folder)) {
            throw new Exception("Thư mục đích không tồn tại: " . PATH_ASSETS_UPLOADS . $folder);
        }

        // Kiểm tra quyền ghi thư mục
        if (!is_writable(PATH_ASSETS_UPLOADS . $folder)) {
            throw new Exception("Không có quyền ghi vào thư mục: " . PATH_ASSETS_UPLOADS . $folder);
        }

        // Kiểm tra lỗi upload của PHP
        if ($file["error"] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => "File vượt quá kích thước cho phép từ cấu hình php.ini",
                UPLOAD_ERR_FORM_SIZE => "File vượt quá kích thước form cho phép",
                UPLOAD_ERR_PARTIAL => "File chỉ được upload một phần",
                UPLOAD_ERR_NO_FILE => "Không có file được upload",
                UPLOAD_ERR_NO_TMP_DIR => "Thiếu thư mục tạm",
                UPLOAD_ERR_CANT_WRITE => "Không thể ghi file vào đĩa",
                UPLOAD_ERR_EXTENSION => "Upload bị chặn bởi extension của PHP",
            ];
            $errMsg = $uploadErrors[$file["error"]] ?? "Lỗi không xác định khi upload file";
            throw new Exception("Upload thất bại: " . $errMsg);
        }

        // Di chuyển file
        if (!move_uploaded_file($file["tmp_name"], $destination)) {
            throw new Exception("Không thể di chuyển file tới: " . $destination);
        }

        return $targetFile;
    }
}
//hàm kiểm tra đăng nhập để thực hiện một số chức năng bắt buộc
function require_Login()
{

    if (empty($_SESSION['user'])) {
        $_SESSION['success'] = false;
        $_SESSION['msg'] = "Bạn phải đăng nhập để tiếp tục thao tác";
        header("Location:" . BASE_URL . "?action=form_signin");
        exit();
    }
}
