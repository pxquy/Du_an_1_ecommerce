<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./admin/views/layout/dashboards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="./admin/views/<?= $view . ".css" ?>">
    <script src="./admin/views/layout/dashboards.js"></script>
</head>

<body>
    <div class=" admin-container">
        <?php require_once PATH_VIEW_ADMIN . 'layout/sidebar.php'; ?>

        <main class="main-content">

            <?php require_once PATH_VIEW_ADMIN . 'layout/header.php'; ?>

            <div class="dashboard">
                <div class="dashboard-header">
                    <h1 class="dashboard-title"><?= $title ?? 'Admin Dashboard' ?></h1>

                    </p>

                    <?php
                    if (isset($view)) {
                        require_once PATH_VIEW_ADMIN . $view . '.php';
                    } else
                        require_once PATH_VIEW_ADMIN . 'dashboard.php';

                    ?>
                </div>
            </div>

        </main>
    </div>
    <!-- <nav class="navbar navbar-expand-xxl bg-light justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN ?>"><b>dashboard</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=users-index' ?>"><b>Quan ly
                        user</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=categories-index' ?>"><b>Quan ly
                        category</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=products-index' ?>"><b>Quan ly
                        product</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=brands-index' ?>"><b>Quan ly
                        brand</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=banners-index' ?>"><b>Quan ly
                        banner</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=slideshows-index' ?>"><b>Quan ly
                        slideshow</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=comments-index' ?>"><b>Quan ly
                        comment</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=vouchers-index' ?>"><b>Quan ly
                        voucher</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=news-index' ?>"><b>Quan ly
                        news</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=attributes-index' ?>"><b>Quan ly
                        attribute</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=attributeValues-index' ?>"><b>Quan
                        ly attribute values</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=variants-index' ?>"><b>Quan ly
                        variant</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=orders-index' ?>"><b>Quan ly
                        Orders</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=categories-index' ?>"><b>Quan ly category</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=products-index' ?>"><b>Quan ly product</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=brands-index' ?>"><b>Quan ly brand</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=banners-index' ?>"><b>Quan ly banner</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=slideshows-index' ?>"><b>Quan ly slideshow</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=comments-index' ?>"><b>Quan ly comment</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=vouchers-index' ?>"><b>Quan ly voucher</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=news-index' ?>"><b>Quan ly news</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=attributes-index' ?>"><b>Quan ly attribute</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=attributesValues-index' ?>"><b>Quan ly attribute values</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=variants-index' ?>"><b>Quan ly variant</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN .'&action=orders-index' ?>"><b>Quan ly Orders</b></a>
            </li>
        </ul>
    </nav> -->


    <!-- <div class="container">
        <h1 class="mt-3"><?= $title ?? 'Admin Dashboard' ?></h1>
        <div class="row">
            
            // if (isset($view)) {
                // require_once PATH_VIEW_ADMIN . $view . '.php';
            // }
          
        </div>
    </div> -->

</body>

</html>