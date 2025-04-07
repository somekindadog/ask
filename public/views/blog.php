<?php
titlePage("Thư viện");
$db = include './config/database.php';
$categoryController = new Category_Controller($db);
$productController = new Product_Controller($db);
?>
<main>
    <div id="home">
        <?= $categoryController->showCategoriesAside() ?>
        <article>
            <?php include './component/fillter.php' ?>
            <?= $productController->showProductListWeb() ?>
        </article>
    </div>
</main>
<!-- /* ------------------------------- JAVASCRIPT ------------------------------- */ -->
<script src="./public/javascript/filter-product.js"></script>
<script src="./public/javascript/search.js"></script>
<!-- /* ------------------------------- JAVASCRIPT ------------------------------- */ -->