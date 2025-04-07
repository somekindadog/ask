<table class="table" style="width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Bài viết</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $comment): ?>
            <tr>
                <td><?= $comment['id'] ?></td>
                <td><?= $comment['userName'] ?></td>
                <td><?= $comment['productName'] ?></td>
                <td><?= $comment['content'] ?></td>
                <td>
                    <span
                        class="badge <?= $comment['status'] === 'approved' ? 'bg-success' : ($comment['status'] === 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                        <?= $comment['status'] === 'approved' ? 'Đã duyệt' : ($comment['status'] === 'pending' ? 'Chờ duyệt' : 'Từ chối') ?>
                    </span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                <td>
                    <div class="btn-group">
                        <a href="?room=edit-comment&id=<?= $comment['id'] ?>" class="black">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="?room=comments&action=delete-comment&id=<?= $comment['id'] ?>" class="red"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                        <?php if ($comment['status'] == 'pending'): ?>
                            <form action="?action=approve-comment" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" name="approve-comment" class="green">
                                    <i class="fas fa-check"></i> Duyệt
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- Xử lý hiển thị -->
<?= (isset($alertDelete) && $alertDelete === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Xóa thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=comments';}});</script>" : "" ?>
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Cập nhật thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=comments';}});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>