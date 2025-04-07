<div id="form-auth">
    <form action="?action=register" method="POST" onsubmit="return validateRegister();">
        <h1>Đăng ký</h1>
        <label for="username">Tên đăng nhập</label>
        <input name="username" type="text" id="username" placeholder="Nhập tên đăng nhập">
        <label for="email">Email</label>
        <input name="email" type="email" id="email" placeholder="Nhập Email">
        <label for="password">Mật khẩu</label>
        <input name="password" type="password" id="password" placeholder="Nhập mật khẩu">
        <label for="confirmpassword">Xác nhận mật khẩu</label>
        <input name="confirmpassword" type="password" id="confirmpassword" placeholder="Xác nhập mật khẩu">
        <div id="error-confirm"></div>
        <button name="register">Đăng ký</button>
        <div class="more-form">
            <span>Bạn đã là thành viên?</span>
            <a href="?auth=login">Đăng nhập</a>
        </div>
        <div class="more-form">
            <a href="../" class="back-web">Trở lại trang web</a>
        </div>
    </form>
</div>
<!-- Xử lí hiển thị -->
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Đăng ký tài khoản thành công',});</script>" : ""?>
<?= (isset($result) && $result === "Tài khoản đã được đăng ký") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Tài khoản đã được đăng ký',});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<!-- Xử lí hiển thị -->