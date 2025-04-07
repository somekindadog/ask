<div class="container">
    <h3 class="page-title">Chỉnh sửa bình luận</h3>
    <form action="?room=edit-comment&id=<?= $dataOld['id'] ?>" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="user">Người dùng</label>
                <input type="text" class="form-control" value="<?= $dataOld['userName'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="post">Bài viết</label>
                <input type="text" class="form-control" value="<?= $dataOld['productName'] ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="content">Nội dung bình luận</label>
            <textarea class="form-control" name="content" id="content" rows="6"
                placeholder="Nhập nội dung bình luận"><?= $dataOld['content'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" name="status" id="status">
                <option value="pending" <?= $dataOld['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                <option value="approved" <?= $dataOld['status'] === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
                <option value="rejected" <?= $dataOld['status'] === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="edit-comment" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập nhật
            </button>
            <a href="?room=comments" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-title {
        margin: 0 0 30px;
        font-size: 20px;
        color: #333;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn i {
        font-size: 14px;
    }

    .btn-primary {
        background: #4a90e2;
        color: white;
    }

    .btn-primary:hover {
        background: #357abd;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        margin-left: 10px;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }
</style>

<!-- Xử lý hiển thị -->
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Cập nhật thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=comments';}});</script>" : "" ?>
<?= (isset($result) && $result === "Chưa nhập đầy đủ thông tin") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Chưa nhập đầy đủ thông tin!',});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>