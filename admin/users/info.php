<div class="info-container">
    <div class="info-header">
        <h1>Thông tin người dùng</h1>
    </div>

    <div class="info-grid">
        <!-- Cột thông tin cơ bản -->
        <div class="info-section">
            <h2>Thông tin cơ bản</h2>
            <form action="?room=update-user-info" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['user']['id']; ?>">
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" name="username" id="username"
                        class="form-input <?php echo (!empty($data['username_err'])) ? 'error' : ''; ?>"
                        value="<?php echo $data['user']['userName']; ?>">
                    <?php if (!empty($data['username_err'])): ?>
                        <span class="error-message"><?php echo $data['username_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email"
                        class="form-input <?php echo (!empty($data['email_err'])) ? 'error' : ''; ?>"
                        value="<?php echo $data['user']['email']; ?>">
                    <?php if (!empty($data['email_err'])): ?>
                        <span class="error-message"><?php echo $data['email_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Cập nhật thông tin</button>
                </div>
            </form>
        </div>

        <!-- Cột đổi mật khẩu -->
        <div class="info-section">
            <h2>Đổi mật khẩu</h2>
            <form action="?room=update-user-password" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['user']['id']; ?>">

                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại:</label>
                    <input type="password" name="current_password" id="current_password"
                        class="form-input <?php echo (!empty($data['current_password_err'])) ? 'error' : ''; ?>">
                    <?php if (!empty($data['current_password_err'])): ?>
                        <span class="error-message"><?php echo $data['current_password_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="new_password">Mật khẩu mới:</label>
                    <input type="password" name="new_password" id="new_password"
                        class="form-input <?php echo (!empty($data['new_password_err'])) ? 'error' : ''; ?>">
                    <?php if (!empty($data['new_password_err'])): ?>
                        <span class="error-message"><?php echo $data['new_password_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                        class="form-input <?php echo (!empty($data['confirm_password_err'])) ? 'error' : ''; ?>">
                    <?php if (!empty($data['confirm_password_err'])): ?>
                        <span class="error-message"><?php echo $data['confirm_password_err']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Xử lý hiển thị thông báo -->
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Cập nhật thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Chưa nhập đầy đủ thông tin") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Chưa nhập đầy đủ thông tin!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Email không hợp lệ") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Email không hợp lệ!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Tên đăng nhập đã tồn tại") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Tên đăng nhập đã tồn tại!',});</script>" : "" ?>
<?= (isset($result) && $result === "Email đã tồn tại") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Email đã tồn tại!',});</script>" : "" ?>
<?= (isset($result) && $result === "Mật khẩu mới phải có ít nhất 6 ký tự") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Mật khẩu mới phải có ít nhất 6 ký tự!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Mật khẩu xác nhận không khớp") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Mật khẩu xác nhận không khớp!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>
<?= (isset($result) && $result === "Mật khẩu hiện tại không chính xác") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Mật khẩu hiện tại không chính xác!',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=information-user&id=" . $_POST['id'] . "';}});</script>" : "" ?>