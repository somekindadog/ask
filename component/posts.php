<div class="product-container">
    <h3>
        <?php
        $db = require './config/database.php';
        $productController = new Product_Controller($db);
        $title = (isset($_GET["title"])) ? $_GET["title"] : "bài viết";
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
            // require_once '../component/functionsHTML.php';
            messRed("Chưa có bài viết !!!");
        }
        ?>
    </div>
</div>
