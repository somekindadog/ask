<!-- /* --------------------------------- ROUTER --------------------------------- */ -->
<?php
include '../component/functionsHTML.php';
include '../config/config.php';
/* ---------------------------------- MODEL --------------------------------- */
include '../models/product-model.php';
include '../models/category-model.php';
include '../models/banner-model.php';
include '../models/comment-model.php';
include '../models/keyword-comment-model.php';
/* ---------------------------------- MODEL --------------------------------- */
/* ---------------------------------- CONTROLLER --------------------------------- */
include '../controllers/product-controller.php';
include '../controllers/category-controller.php';
include '../controllers/banner-controller.php';
include '../controllers/comment-controller.php';
include '../controllers/keyword-comment-controller.php';
/* ---------------------------------- CONTROLLER --------------------------------- */
/* ---------------------------------- AUTH ---------------------------------- */
include './auth-role.php'; // Xác thực quyền
// controller và model user nằm trong auth-role
/* ---------------------------------- AUTH ---------------------------------- */
define("ROOM", isset($_GET["room"]) ? $_GET["room"] : "");
define("ACTION", isset($_GET["action"]) ? $_GET["action"] : "");

echo ROOM;
/* -------------------------------- VIEW MAIN ------------------------------- */
$pdo = require '../config/database.php';
$userController = new User_Controller($pdo);
$categoryController = new Category_Controller($pdo);
$productController = new Product_Controller($pdo);
$bannerController = new Banner_Controller($pdo);
$commentController = new Comment_Controller($pdo);
$keywordController = new Keyword_Comment_Controller($pdo);
if (!empty(ROOM)) {
    if (ROOM === 'dashboard') { // Thêm route cho dashboard
        include './views/dashboard.php';
    } elseif (ROOM === 'users') { // trang tài khoản người dùng
        $userController->showUserList();
    } elseif (ROOM === 'information-user') { // trang thông tin người dùng
        $userController->showUserInfo();
    } elseif (ROOM === 'update-user-info') { // cập nhật thông tin người dùng
        $userController->updateUserInfo();
    } elseif (ROOM === 'update-user-password') { // cập nhật mật khẩu người dùng
        $userController->updateUserPassword();
    } elseif (ROOM === 'posts') { // trang bài viết
        $productController->showProductList();
    } elseif (ROOM === 'add-product') { // trang thêm bài viết
        $productController->addProduct();
    } elseif (ROOM === 'edit-product') { // trang sửa bài viết
        $productController->editProduct();
    } elseif (ROOM === 'images') { // trang ảnh chi tiết bài viết
        $productController->showAImageMore();
    } elseif (ROOM === 'banners') { // trang banner
        $bannerController->showBannerList();
    } elseif (ROOM === 'add-banner') { // trang thêm banner
        include './banners/add-banner.php';
    } elseif (ROOM === 'edit-banner') { // trang sửa banner
        $bannerController->editBanner();
    } elseif (ROOM === 'details-product') { // trang chi tiết bài viết
        $productController->detailsProduct();
    } elseif (ROOM === 'add-category') { // trang thêm danh mục
        include './categories/add-category.php';
    } elseif (ROOM === 'edit-category') { // trang sửa danh mục
        $categoryController->editCategory();
    } elseif (ROOM === 'categories') { // trang danh mục
        $categoryController->showCategories();
    } elseif (ROOM === 'comments') { // quản lý bình luận
        $commentController->showComments();
    } elseif (ROOM === 'edit-comment') { // chỉnh sửa bình luận
        $commentController->editComment();
    } elseif (ROOM === 'keywords') {
        $keywordController->showKeywords();
    }
    // NOT FOUND
    else {
        header("Location: ../404/");
    }
    // NOT FOUND
}
/* -------------------------------- VIEW MAIN ------------------------------- */
/* --------------------------------- ACTION --------------------------------- */
if (!empty(ACTION)) {
    if (ACTION === 'updateUser') { // cập nhật trạng thái tài khoản người dùng
        $userController->updateUser();
        header("Location: ./?room=users");
    } elseif (ACTION === 'update-user-info') { // cập nhật thông tin người dùng
        $userController->updateUserInfo();
    } elseif (ACTION === 'update-user-password') { // cập nhật mật khẩu người dùng
        $userController->updateUserPassword();
    } elseif (ACTION === 'add-category') { // thêm danh mục
        $categoryController->addCategory();
    } elseif (ACTION === 'edit-category') { // sửa danh mục
        $categoryController->editCategory();
    } elseif (ACTION === 'delete-category') { // xóa danh mục
        $categoryController->deleteCategory();
    } elseif (ACTION === 'add-product') { // thêm bài viết
        $productController->addProduct();
    } elseif (ACTION === 'edit-product') { // sửa bài viết
        $productController->editProduct();
    } elseif (ACTION === 'update-status-product') { // cập nhật trạng thái bài viết
        $productController->updateStatusProduct();
    } elseif (ACTION === 'delete-product') { // xóa bài viết
        $productController->deleteProduct();
    } elseif (ACTION === 'delete-image') { // xóa ảnh bài viết
        $productController->deleteImageMore();
    } elseif (ACTION === 'add-banner') { // thêm banner
        $bannerController->addBanner();
    } elseif (ACTION === 'edit-banner') { // sửa banner 
        $bannerController->editBanner();
    } elseif (ACTION === 'update-banner') { // cập nhật trạng thái banner
        $bannerController->updateBanner();
    } elseif (ACTION === 'delete-banner') { // xóa banner
        $bannerController->deleteBanner();
    } elseif (ACTION === 'delete-comment') { // xóa bình luận
        $commentController->deleteComment();
    } elseif (ACTION === 'approve-comment') { // duyệt bình luận
        $commentController->approveComment();
    } elseif (ACTION === 'add') {
        $keywordController->addKeyword();
    } elseif (ACTION === 'delete') {
        $keywordController->deleteKeyword();
    }
}
/* --------------------------------- ACTION --------------------------------- */
?>
<!-- /* --------------------------------- ROUTER --------------------------------- */ -->