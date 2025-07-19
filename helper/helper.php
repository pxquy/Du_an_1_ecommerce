<?php
if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
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

function genId($n, $prefix = null)
{
    $character = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $id = $prefix;
    $maxIndex = strlen($character) - 1;
    for ($i = 0; $i < $n - 1; $i++) {
        $id .= $character[random_int(0, $maxIndex)];
    }
    return $id;
}

function slugify($string)
{
    // Chuyển về chữ thường
    $string = mb_strtolower($string, 'UTF-8');

    // Loại bỏ dấu tiếng Việt
    $string = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $string);
    $string = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $string);
    $string = preg_replace('/[íìỉĩị]/u', 'i', $string);
    $string = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $string);
    $string = preg_replace('/[úùủũụưứừửữự]/u', 'u', $string);
    $string = preg_replace('/[ýỳỷỹỵ]/u', 'y', $string);
    $string = preg_replace('/[đ]/u', 'd', $string);

    // Loại bỏ ký tự không hợp lệ
    $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string); // bỏ trùng dấu -
    $string = trim($string, '-');

    return $string;
}

function dequy($arrays, $index = 0, $current = [], &$result = [])
{
    if ($index === count($arrays)) {
        $result[] = implode('-', $current);
        return;
    }

    foreach ($arrays[$index] as $value) {
        dequy($arrays, $index + 1, array_merge($current, [$value]), $result);
    }

    return $result;
}

//hàm kiểm tra đăng nhập để thực hiện một số chức năng bắt buộc
function require_Login()
{

    if (empty($_SESSION['user'])) {
        $_SESSION['error_message'] = "Bạn phải đăng nhập để tiếp tục thao tác";
        header("Location:" . BASE_URL . "?action=form_signin");
        exit();
    }
    if ($_SESSION['user']['isActive'] == 0) {
        $_SESSION['error_message'] = "Tài khoản cảu bạn đã bị khoá";
        header("location:" . BASE_URL . "?action=form_signin");
        exit();
    }
}

function genId($n, $prefix = null)
{
    $character = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $id = $prefix;
    $maxIndex = strlen($character) - 1;
    for ($i = 0; $i < $n - 1; $i++) {
        $id .= $character[random_int(0, $maxIndex)];
    }
    return $id;
}