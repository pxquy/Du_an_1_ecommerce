<?php
session_start();

spl_autoload_register(function ($class) {
    $fileName = "$class.php";

    $fileModelAdmin = PATH_MODEL_ADMIN . $fileName;
    $fileModelClient = PATH_MODEL_CLIENT . $fileName;
    $fileControllerClient = PATH_CONTROLLER_CLIENT . $fileName;
    $fileControllerAdmin = PATH_CONTROLLER_ADMIN . $fileName;

    if (is_readable($fileModelClient)) {
        require_once $fileModelClient;
    } else if (is_readable($fileControllerClient)) {
        require_once $fileControllerClient;
    } else if (is_readable($fileControllerAdmin)) {
        require_once $fileControllerAdmin;
    } else if (is_readable($fileModelAdmin)) {
        require_once $fileModelAdmin;
    }
});

require_once './config/env.php';
require_once './helper/helper.php';

$mode = $_GET['mode'] ?? 'client';

if ($mode == 'admin') {
    require_once './routes/admin/admin_routes.php';
} else {
    require_once './routes/client/client_routes.php';
}
