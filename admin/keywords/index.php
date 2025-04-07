<!-- Form thêm từ khóa -->
<form action="?action=add" method="POST" class="add-form" style="margin-top:20px">
    <div class="">
        <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa cấm" required>
    </div>
    <button class="black">
        <i class="fas fa-plus"></i> Thêm từ khóa
    </button>
</form>

<table class="table" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Từ khóa</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($keywords) && $keywords): ?>
            <?php foreach ($keywords as $keyword): ?>
                <tr>
                    <td><?= $keyword['id'] ?></td>
                    <td><?= htmlspecialchars($keyword['keyword']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($keyword['created_at'])) ?></td>
                    <td>
                        <form action="?action=delete" method="POST" class="delete-form">
                            <input type="hidden" name="id" value="<?= $keyword['id'] ?>">
                            <button type="submit" class="red"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa từ khóa này?')">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>

<style>
    .add-form {
        display: flex;
        margin-bottom: 10px;
    }

    .add-form input {
        padding: 10px 20px;
    }

    .add-form button {
        color: white;
        padding: 0 10px;
    }
</style>

<!-- Xử lý hiển thị -->
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Thêm từ khóa thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=keywords';}});</script>" : "" ?>
<?= (isset($result) && $result === "Từ khóa này đã tồn tại") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Từ khóa này đã tồn tại!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=keywords';}});</script>" : "" ?>
<?= (isset($result) && $result === "Chưa nhập đầy đủ thông tin") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Chưa nhập đầy đủ thông tin!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=keywords';}});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=keywords';}});</script>" : "" ?>
<!-- Xử lý hiển thị -->