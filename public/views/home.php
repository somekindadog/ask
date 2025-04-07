<?php
$pdo = include './config/database.php';
$categoryController = new Category_Controller($pdo);
$productController = new Product_Controller($pdo);
$bannerController = new Banner_Controller($pdo);
?>
<main style="padding: 20px 150px;">
    <article>
        <?= $bannerController->showBannerListWeb() ?>
        <?= $productController->showProductByStatusLimit("NỔI BẬT",'hot', 10) ?>
        <div class="view-more"><button onclick="window.location.href = '?page=library'">Xem tất cả</button></div>
        <?= $productController->showProductByStatusLimit("MỚI NHẤT",'new', 10) ?>
        <div class="view-more"><button onclick="window.location.href = '?page=library'">Xem tất cả</button></div>
    </article>
</main>
<!-- /* ------------------------------- JAVASCRIPT ------------------------------- */ -->
<script src="./public/javascript/filter-product.js"></script>
<script src="./public/javascript/search.js"></script>
<!-- /* ------------------------------- JAVASCRIPT ------------------------------- */ -->