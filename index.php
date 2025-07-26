<?php
session_start();

// spl_autoload_register(function ($class) {
//     $fileName = "$class.php";
//     $fileModelAdmin = PATH_MODEL_ADMIN . $fileName;
//     $fileModelClient = PATH_MODEL_CLIENT . $fileName;
//     $fileControllerClient = PATH_CONTROLLER_CLIENT . $class . '/' . $fileName;
//     $fileControllerAdmin = PATH_CONTROLLER_ADMIN . $fileName;

//     error_log("[Autoload] Attempting to load class: $class");
//     echo "<pre>[Autoload] Attempting to load class: $class</pre>";

//     if (is_readable($fileModelClient)) {
//         error_log("[Autoload] Loading from Model Client: $fileModelClient");
//         echo "<pre>[Autoload] Loading from Model Client: $fileModelClient</pre>";
//         require_once $fileModelClient;
//     } else if (is_readable($fileControllerClient)) {
//         error_log("[Autoload] Loading from Controller Client: $fileControllerClient");
//         echo "<pre>[Autoload] Loading from Controller Client: $fileControllerClient</pre>";
//         require_once $fileControllerClient;
//     } else if (is_readable($fileControllerAdmin)) {
//         error_log("[Autoload] Loading from Controller Admin: $fileControllerAdmin");
//         echo "<pre>[Autoload] Loading from Controller Admin: $fileControllerAdmin</pre>";
//         require_once $fileControllerAdmin;
//         require_once $fileControllerAdmin;
//     } else if (is_readable($fileModelAdmin)) {
//         error_log("[Autoload] Loading from Model Admin: $fileModelAdmin");
//         echo "<pre>[Autoload] Loading from Model Admin: $fileModelAdmin</pre>";
//         require_once $fileModelAdmin;
//     } else {
//         error_log("[Autoload] FAILED to load class: $class");
//         echo "<pre>[Autoload] FAILED to load class: $class</pre>";
//     }
// });

require_once './config/env.php';
require_once './helper/helper.php';

$mode = $_GET['mode'] ?? 'client';

spl_autoload_register(function ($class) use ($mode) {
    $fileName = "$class.php";

    if ($mode === 'admin') {
        $paths = [
            PATH_MODEL_ADMIN . $fileName,
            PATH_CONTROLLER_ADMIN . $fileName,
        ];
    } else {
        // mặc định là client
        $paths = [
            PATH_MODEL_CLIENT . $fileName,
            PATH_CONTROLLER_CLIENT . $class . '/' . $fileName, // nếu bạn dùng folder riêng cho từng controller
            PATH_CONTROLLER_CLIENT . $fileName, // fallback nếu đặt trực tiếp
        ];
    }

    foreach ($paths as $path) {
        if (is_readable($path)) {
            // echo "<pre>[Autoload] Loaded: $path</pre>";
            require_once $path;
            return;
        }
    }

    // echo "<pre>[Autoload] FAILED to load class: $class</pre>";
});


if ($mode == 'admin') {
    require_once './routes/admin/admin_routes.php';
} else {
    require_once './routes/client/client_routes.php';
}
