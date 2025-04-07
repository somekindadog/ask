<!-- -------------------------------- SLIDE -------------------------------- -->
<div class="slider-container">
    <div class="slides">
    <?php 
    if(isset($result)){
        ?>
            <?php 
            $index = 1;
            foreach ($result as $banner) :
                ?>
                <div class="slide"><img width="100%" height="400px" style="object-fit: cover;" src="./public/image/<?= $banner['image']?>" alt="Slide <?= $index  ?>"></div>
                <?php //HTML
                $index++;
            endforeach;
            ?>
        <?php //HTML
    }
    ?>
    </div>
    <button id="prevBtn" onclick="prevSlide()">&#10094;</button>
    <button id="nextBtn" onclick="nextSlide()">&#10095;</button>
</div>
<!-- -------------------------------- SLIDE -------------------------------- -->
<!-- /* --------------------------------- SCRIPT --------------------------------- */ -->
<script src="./public/javascript/banner.js"></script>
<!-- /* --------------------------------- SCRIPT --------------------------------- */ -->