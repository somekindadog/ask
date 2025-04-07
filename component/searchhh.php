<main>
<?php include './component/fillter.php'; ?>
<div class="product-container">
    <h3>
        <?php
        $page = (isset($_GET["page"])) ? $_GET["page"] : "TẤT CẢ";
        if($page === 'search'){
            messGreen("Kết quả tìm kiếm: "); 
            ?>
            <span id="showNumSearch" style="color: green;">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.getElementById('showNumSearch').innerHTML = document.getElementById('numSearch').value + " kết quả";
                    });
                </script>
            </span>
            <?php //HTML
        }else{
            echo ucfirst($page);
        }
        ?>
    </h3>
    <div id="product-list">
        <?php
        if(isset($posts)){
            $numSearch = 0;
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
            $numSearch ++;
            endforeach;
            ?><input type="hidden" id="numSearch" value="<?= $numSearch ?>"><?php //HTML
        }else{
            messRed("Không tìm thấy !!!");
        }
        ?>
    </div>
    </div>
</div>
</main>