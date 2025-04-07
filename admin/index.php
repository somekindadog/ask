<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FAVICON -->
    <link rel="shortcut icon"
        href="https://cdn0.iconfinder.com/data/icons/social-network-27/32/blogger_logo_social_publishing_web_service_blogpost-512.png"
        type="image/x-icon">
    <!-- FAVICON -->
    <!-- CSS -->
    <link rel="stylesheet" href="../public/css/common-style.css">
    <link rel="stylesheet" href="../public/css/header-style.css">
    <link rel="stylesheet" href="../public/css/banner-style.css">
    <link rel="stylesheet" href="../public/css/home-style.css">
    <link rel="stylesheet" href="../public/css/footer-style.css">
    <link rel="stylesheet" href="../public/css/responsive.css">
    <link rel="stylesheet" href="../public/css/admin-style.css">
    <link rel="stylesheet" href="../public/css/root.css">
    <link rel="stylesheet" href="../public/css/info-style.css">
    <!-- CSS -->
    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- ICON -->
    <!-- ALERT -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.all.min.js"></script>
    <!-- ALERT -->
    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CHART.JS -->
    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <!-- CKEDITOR -->
    <title>Admin</title>
</head>

<body>
    <div id="root">
        <div id="dashboard">
            <div class="controller-dashboard">
                <div>
                    <h1>DashBoard</h1>
                    <a href="../?page=home"><i class="fa-solid fa-earth-americas fa-spin fa-spin-reverse"></i>
                        Website</a>
                    <a href="?room=users"><i class="fa-solid fa-users"></i> Người dùng</a>
                    <a href="?room=banners"><i class="fa-solid fa-sliders"></i> Banner</a>
                    <a href="?room=keywords"><i class="fa-solid fa-sliders"></i> Từ cấm</a>
                    <a href="?room=comments"><i class="fa-solid fa-sliders"></i> Bình luận</a>
                    <li>
                        <a href="?room=categories"><i class="fa-solid fa-calendar-days"></i> Danh mục</a>
                        <div class="item-more-admin">
                            <a href="?room=add-category"><i class="fa-solid fa-plus"></i></a>
                        </div>
                    </li>
                    <li>
                        <a href="?room=posts"><i class="fa-solid fa-boxes-stacked"></i> Bài viết</a>
                        <div class="item-more-admin">
                            <a href="?room=add-product"><i class="fa-solid fa-plus"></i></a>
                        </div>
                    </li>
                </div>
                <a href="../auth/?action=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất</a>
            </div>
            <div class="content-dashboard">

                <!-- /* -------------------------------- VIEW MAIN ------------------------------- */ -->
                <?php include './router-admin.php' // Tất cả các trang của admin được chạy ở đây ?>
                <!-- /* -------------------------------- VIEW MAIN ------------------------------- */ -->
            </div>
        </div>
    </div>
    <!-- /* --------------------------------- SCRIPT --------------------------------- */ -->
    <script src="../public/javascript/alert-condition.js"></script>
    <script src="../public/javascript/admin/banners.js"></script>
    <script src="../public/javascript/admin/categories.js"></script>
    <script src="../public/javascript/admin/posts.js"></script>
    <script src="../public/javascript/admin/add-image-product.js"></script>
    <script src="../public/javascript/admin/ckeditor.js"></script>
    <!-- /* --------------------------------- SCRIPT --------------------------------- */ -->
    <script src="../public/javascript/snowfall.js"></script>
</body>

</html>