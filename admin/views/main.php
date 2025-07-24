<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-xxl bg-light justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN ?>"><b>dashboard</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase" href="<?= BASE_URL_ADMIN . '&action=users-index' ?>"><b>Quan ly
                        user</b></a>
            </li>
        </ul>
    </nav>


    <div class="container">
        <h1 class="mt-3"><?= $title ?? 'Admin Dashboard' ?></h1>
        <div class="row">
            <?php
            if (isset($view)) {
                // debug($view);
                require_once PATH_VIEW_ADMIN . $view . '.php';
            }
            ?>
        </div>
    </div>

</body>

</html>