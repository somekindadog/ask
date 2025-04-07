<main style="padding: 20px 150px;">
    <?php
    if (isset($product)) {
        ?>
        <div id="read-blog">
            <h1><?= $product['productName'] ?></h1><br>
            <?= $product['details'] ?>
        </div>

        <!-- Phần bình luận -->
        <div class="comment-section product-container">
            <h2>Bình luận</h2>

            <!-- Form bình luận -->
            <?php if (isset($_SESSION['user'])): ?>
                <div class="comment-form">
                    <form action="" method="POST">
                        <textarea name="content" placeholder="Viết bình luận của bạn..." required></textarea>
                        <input type="hidden" value="<?= $_GET['id'] ?>" name="post_id">
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i> Gửi bình luận
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="comment-form">
                    <p>Vui lòng <a href="?page=login">đăng nhập</a> để bình luận</p>
                </div>
            <?php endif; ?>

            <!-- Danh sách bình luận -->
            <div class="comments-list">
                <?php
                // không cần requie model vì nó đã được gọi sẵn
                $db = require './config/database.php';
                $commentModel = new Comment_Model($db);
                $comments = $commentModel->getByPostId($product['id']);

                if (!empty($comments)):
                    foreach ($comments as $comment):
                        ?>
                        <div class="comment-item">
                            <div class="comment-header">
                                <span class="comment-user">
                                    <i class="fa-regular fa-user"></i>
                                    <?= htmlspecialchars($comment['userName'] ?? '') ?>
                                    (<?= date('d/m/Y H:i', strtotime($comment['created_at'] ?? 'now')) ?>)
                                </span>
                                <span class="comment-date"></span>
                            </div>
                            <div class="comment-content">
                                <?= nl2br(htmlspecialchars($comment['content'] ?? '')) ?>
                            </div>
                            <?php if (isset($comment['status']) && $comment['status'] === 'pending'): ?>
                                <div class="comment-status">Bình luận đang chờ duyệt</div>
                            <?php endif; ?>
                        </div>
                        <?php
                    endforeach;
                else:
                    ?>
                    <div class="no-comments">
                        Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <script>window.location.href = '?page=library'</script>
        <?php
    }
    ?>
    <!-- /* -------------------------------- ALL BLOG -------------------------------- */ -->
    <br>
    <?php
    $db = require './config/database.php';
    $productController = new Product_Controller($db);
    $productController->showProductListByCategory($product['categoryId']);
    ?>
    <!-- /* -------------------------------- ALL BLOG -------------------------------- */ -->
</main>