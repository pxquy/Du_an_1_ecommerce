<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Trang chủ' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <style>
        .hero {
            padding: 100px 0;
            background-color: #f8f9fa;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">

        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-uppercase">Title</th>
                        <th class="text-uppercase">Price</th>
                        <th class="text-uppercase">Discount</th>
                        <th class="text-uppercase">Slug</th>
                        <th class="text-uppercase">Created At</th>
                        <th class="text-uppercase">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-uppercase"><?= $product['title'] ?></td>
                            <td class="text-uppercase"><?= $product['priceDefault'] ?></td>
                            <td class="text-uppercase"><?= $product['discountPercentage'] ?></td>
                            <td class="text-uppercase"><?= $product['slug'] ?></td>
                            <td class="text-uppercase"><?= $product['createdAt'] ?></td>
                            <td class="text-uppercase"><?= $product['updatedAt'] ?></td>
                        </tr>
                    <?php endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">© 2025 Tên Công Ty. All rights reserved.</p>
        </div>
    </footer>

</body>


</html>