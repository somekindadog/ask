<?php
include '../component/functionsHTML.php';
include '../models/category-model.php';
include '../models/product-model.php';
include '../models/comment-model.php';
include '../controllers/product-controller.php';
$db = include '../config/database.php';
$productController = new Product_Controller($db);
$productController->filterProduct();
?>