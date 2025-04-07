<header>
    <div class="header-top">
        <div class="logo"><a href="?page=home" style="display: flex; align-items: center; gap: 10px"><img src="https://cdn.freebiesupply.com/images/large/2x/blogger-logo-transparent.png" width="50px" alt=""> BaoMoiVN</a></div>
        <!-- /* ----------------------------- SEARCH DESKTOP ----------------------------- */ -->
        <form method="POST" action="?page=search" class="search" onsubmit="return true">
            <input type="text" name="keyword" id="keyword" placeholder="Bạn muốn mua gì hôm nay?">
            <button name="search" id="search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <!-- /* ----------------------------- SEARCH DESKTOP ----------------------------- */ -->
        <div class="bell-cart-user">
            <a href="#">
                <i class="fa-regular fa-bell"></i>
                <span>99</span>
                <div class="notification">
                    <span>
                        <i class="fa-solid fa-bullhorn"></i>
                        Chào mừng bạn đến với chúng tôi !!!
                        <div class="notification-time">16/10/2024</div>
                    </span>
                </div>
            </a>
            <?php
            if (isset($ss_role) && isset($ss_id)) { // Kiểm tra đã đăng nhập chưa
            ?>
                <div class="user">
                    <i class="fa-regular fa-user"></i>
                    <div class="profile-item">
                        <!-- NHỚ VALIDATE  -->
                        <?php
                        if ($ss_role === "admin" || $ss_role === "staff") {
                            ?><a href="?page=admin"><i class="fa-solid fa-screwdriver-wrench"></i> Quản trị</a><?php // HTML
                        }
                        ?>
                        <!-- NHỚ VALIDATE  -->
                        <a href="./auth/?action=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất</a>
                    </div>
                </div>
            <?php //HTML
            }else{
            ?><a href="./auth/?action=logout"><i class="fa-regular fa-user"></i></a><?php // HTML
            }
            ?>
        </div>
        <!-- /* --------------------------- FORM SEARCH MOBILE --------------------------- */ -->
        <form method="POST" action="?page=search" class="search search-mobile" onsubmit="return true">
            <input type="text" name="keyword" id="keyword_mobile" placeholder="What do you want to buy today?">
            <button name="search" id="search_mobile"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <!-- /* --------------------------- FORM SEARCH MOBILE --------------------------- */ -->
    </div>
    <!-- /* ----------------------------------- NAV ---------------------------------- */ -->
    <nav>
        <ul class="menu">
            <li class="menu-item">
                <a href="?page=home">Trang chủ</a>
            </li>
            <li class="menu-item">
                <a href="?page=blog">Bài viết</a>
            </li>
            <li class="menu-item">
                <a href="?page=about">Giới thiệu</a>
            </li>
            <li class="menu-item">
                <a href="?page=policy">Chính sách</a>
            </li>
            <li class="menu-item">
                <a href="?page=contact">Liên hệ</a>
            </li>
        </ul>
    </nav>
    <!-- /* ----------------------------------- NAV ---------------------------------- */ -->
</header>
