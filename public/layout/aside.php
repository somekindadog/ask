<aside>
    <!-- /* ------------------------------ CATEGORY LIST ----------------------------- */ -->
    <div class="category-list">
        <ul>
            <li><i class="fa-solid fa-list"></i> Danh mục bài viết</li>
            <li><a href="?page=library">Tất cả</a></li>
            <?php 
            if(isset($categories)){
                foreach ($categories as $category) :
                ?>
                <li>
                    <a class="filter-link" data-category="<?= htmlspecialchars($category['id']) ?>" href="#"><?= htmlspecialchars($category['categoryName']) ?></a>
                </li>
                <?php // HTML
                endforeach;
            }else{
                ?><span class="span-red">Chưa có danh mục nào</span><?php // HTML
            }
            ?>
        </ul>
    </div>
    <!-- /* ------------------------------ CATEGORY LIST ----------------------------- */ -->
</aside>

