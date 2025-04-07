<form class="input" action="?action=add-product" method="POST" enctype="multipart/form-data" onsubmit="return validateAddProduct()">
    <h1>Thêm bài viết</h1>
    <label for="categoryId">Danh mục</label>
    <select name="categoryId" id="categoryId">
        <?php 
        if(isset($categories)){
            foreach ($categories as $category) :
            ?><option value="<?= $category['id'] ?>"><?= $category['categoryName'] ?></option><?php //HTML
            endforeach;
        }
        ?>
    </select>
    <label for="image">Ảnh</label>
    <input type="file" name="image" id="image" accept="image/jpeg, image/jpg, image/png">
    <label for="">Tiêu đề</label>
    <input type="text" name="productName" id="productName" placeholder="Nhập tiêu đề">
    <label for="">Nội dung</label>
    <textarea name="details" id="details" cols="30" rows="10" placeholder="Nhập nội dung"></textarea>
    <button name="add-product">Thêm bài viết</button>
</form>
<!-- Xử lí hiển thị -->
<?= (isset($result) && $result === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Thêm thành công',}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=posts';}});</script>" : ""?>
<?= (isset($result) && $result === "Chưa nhập đầy đủ thông tin") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Chưa nhập đầy đủ thông tin!',});</script>" : "" ?>
<?= (isset($result) && $result === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<!-- Xử lí hiển thị -->
