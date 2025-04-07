<?php
session_start();
if (isset($_SESSION["user"])) {
    $ss_role = (isset($_SESSION["user"]['role'])) ? $_SESSION["user"]['role'] : "";
    $ss_id = (isset($_SESSION["user"]['id'])) ? $_SESSION["user"]['id'] : "";
}
define("PAGE", (isset($_GET["page"])) ? $_GET["page"] : "");
define("ACTION", (isset($_GET["action"])) ? $_GET["action"] : "");
define("CATEGORY", (isset($_GET["category"])) ? $_GET["category"] : "");
include './component/functionsHTML.php';
/* ---------------------------------- MODEL --------------------------------- */
include './models/user-model.php';
include './models/category-model.php';
include './models/product-model.php';
include './models/banner-model.php';
include "./models/comment-model.php";
include "./models/keyword-comment-model.php";
/* ---------------------------------- MODEL --------------------------------- */
/* ---------------------------------- CONTROLLER --------------------------------- */
include './controllers/user-controller.php';
include './controllers/category-controller.php';
include './controllers/product-controller.php';
include './controllers/banner-controller.php';
/* ---------------------------------- CONTROLLER --------------------------------- */
/* --------------------------------- HEADER --------------------------------- */
if (PAGE === 'admin') {
    // ADMIN
} else {
    include './public/layout/header.php';
}
/* --------------------------------- HEADER --------------------------------- */
$db = require './config/database.php';
$userController = new User_Controller($db);
$productController = new Product_Controller($db);
$categoryController = new Category_Controller($db);
/* -------------------------------- VIEW MAIN (ROUTER) ------------------------------- */
if (!empty(PAGE)) {
    if (PAGE === 'home') { // trang chủ
        include './public/views/home.php';
    } elseif (PAGE === 'about') { // trang giới thiệu
        include './public/views/about.php';
    } elseif (PAGE === 'policy') { // trang chính sách
        include './public/views/policy.php';
    } elseif (PAGE === 'contact') { // trang liên hệ
        include './public/views/contact.php';
    } elseif (PAGE === 'blog') { // trang blog
        include './public/views/blog.php';
    } elseif (PAGE === 'details') { // trang chi tiết 
        $productController->detailsProductWeb();
    } elseif (PAGE === 'search') { // trang tìm kiếm
        $productController->searchhh();
    } elseif (PAGE === 'logout') { // đăng xuất
        header("Location: ./auth/views/logout.php");
    } elseif (PAGE === 'admin') { // trang admin
        header("Location: ./admin/?room=posts");
    }
    // NOT FOUND
    else {
        ?>
        <script>window.location.href = './404/'</script>
        <?php
    }
    // NOT FOUND
} else {
    include './public/views/home.php';
}
/* -------------------------------- VIEW MAIN (ROUTER) ------------------------------- */
/* --------------------------------- LOADING -------------------------------- */
include './component/loading.php';
/* --------------------------------- LOADING -------------------------------- */
/* --------------------------------- FOOTER --------------------------------- */
if (PAGE === 'admin') { // nếu là trang admin thì ko cần footer
    // ADMIN
} else {
    include './public/layout/footer.php';
}
/* --------------------------------- FOOTER --------------------------------- */
?>