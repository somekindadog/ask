<div class="product-container">
    <h3>BẠN CÓ THỂ THÍCH</h3>
    <div id="product-list">
        <?php
        if (isset($maylike)) {
            foreach ($maylike as $product) :
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
        }
        ?>
    </div>
</div>