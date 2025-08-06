<?php

// URL gốc
define('BASE_URL', 'http://localhost/Du_an_1_ecommerce/');
define('BASE_URL_ADMIN', 'http://localhost/Du_an_1_ecommerce/?mode=admin');


// Đường dẫn tuyệt đối đến gốc dự án
define('PATH_ROOT', dirname(__DIR__) . '/');

// Đường dẫn views
define('PATH_VIEW_ADMIN', PATH_ROOT . 'admin/views/');
define('PATH_VIEW_CLIENT', PATH_ROOT . 'client/views/');

// Đường dẫn body
define('PATH_VIEW_ADMIN_MAIN', PATH_VIEW_ADMIN . 'main.php');
define('PATH_VIEW_CLIENT_MAIN', PATH_VIEW_CLIENT . 'home.php');

// Đường dẫn assets
define('BASE_ASSETS_ADMIN', BASE_URL . 'assets/admin/');
define('BASE_ASSETS_CLIENT', BASE_URL . 'assets/client/');
define('BASE_ASSETS_UPLOADS', BASE_URL . 'assets/upload/');
define('PATH_ASSETS_UPLOADS', PATH_ROOT . 'assets/upload/');
// Đường dẫn controller
define('PATH_CONTROLLER_ADMIN', PATH_ROOT . 'admin/controller/');
define('PATH_CONTROLLER_CLIENT', PATH_ROOT . 'client/controller/');

// Đường dẫn model
define('PATH_MODEL_ADMIN', PATH_ROOT . 'admin/model/');
define('PATH_MODEL_CLIENT', PATH_ROOT . 'client/model/');

// Cấu hình DB
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'du_an_1_ecommerce');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
