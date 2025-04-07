<div class="product-container">
    <?php include '../component/fillter.php' ?>
    <h3>
        <?php
        $title = (isset($_GET["title"])) ? $_GET["title"] : "TẤT CẢ bài viết";
        if($title === 'search'){
            messGreen("Kết quả tìm kiếm");
        }else{
            echo ucfirst($title);
        }
        ?>
    </h3>
    <div id="product-list">
        <?php
        if(isset($posts)){
            foreach ($posts as $product) :
            ?>
                <div class="product" data-filter="<?= htmlspecialchars($product['status']) ?>">
                    <a href="?page=details&id=<?= htmlspecialchars($product['id']) ?>">
                        <div class="product-image">
                            <img width="200px" src="./uploads/<?= htmlspecialchars($product['image']) ?>" alt="">
                        </div>
                        <div class="information-product">
                            <div class="title"><?= htmlspecialchars($product['productName']) ?></div>
                        </div>
                    </a>
                </div>
            <?php // HTML
            endforeach;
        }else{
            require_once '../component/functionsHTML.php';
            messRed("Không có bài viết nào !!!");
        }
        ?>
    </div>
</div>
