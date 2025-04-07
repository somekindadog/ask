<table style="width: 100%;">
    <?php 
    if(isset($result) && !empty($result)){
        ?>
        <tr>
            <th>ID</th>
            <th>Mã danh mục</th>
            <th>Ảnh</th>
            <th>Tên bài viết</th>
            <th>Chi tiết</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php // HTML
        $db = include '../config/database.php';
        $productController = new Product_Controller($db);
        foreach ($result as $product) : 
            ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['categoryId'] ?></td>
                <td>
                    <img width="100px" src="../uploads/<?= $product['image'] ?>" alt="">
                </td>
                <td class="productNameTD"><?= $product['productName'] ?></td>
                <td><a class="black" href="?room=details-product&view=details&id=<?= $product['id'] ?>">Xem</a></td>
                <td>
                    <div class="statusMain">
                        <!-- XỬ LÍ HIỂN THỊ CHO ĐẸP THÔI -->
                        <?php 
                        $status = $product['status'];
                        $nameStatus = "";
                        $color = "";
                        if($status === "hot"){
                            $nameStatus = "Nổi bật";
                            $color = "red";
                        }elseif($status === "new"){
                            $nameStatus = "Mới nhất";
                            $color = "green";
                        }else{
                            $nameStatus = "Thường";
                            $color = "black";
                        }
                        ?>
                        <span class="span-<?= $color ?>"><?= $nameStatus ?></span>
                        <!-- XỬ LÍ HIỂN THỊ CHO ĐẸP THÔI -->
                        <form action="?room=posts&action=update-status-product&id=<?= $product['id'] ?>" method="POST" class="statusMore">
                            <button name="action" value="none" class="black">None</button>
                            <button name="action" value="hot" class="red">Nổi bật</button>
                            <button name="action" value="new" class="green">Mới nhất</button>
                        </form>
                    </div>
                </td>
                <td class="actions">
                    <form action="" method="POST">
                        <a class="green" href="?room=edit-product&id=<?= $product['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> Sửa</a>
                        <a class="red" onclick="return confirmDelete('?action=delete-product&id=<?= $product['id'] ?>')" href=""><i class="fa-solid fa-trash-can"></i> Xóa</a>
                    </form>
                </td>
            </tr>
            <?php //HTML
        endforeach;
    }else{
        if(!isset($alertDelete) && !isset($alertUpdate)){
            ?><span class="span-red">Chưa có bài viết nào</span><?php // HTML
        }
    }
    ?>
</table>
<!-- Xử lí hiển thị -->
<?= (isset($alertUpdate) && $alertUpdate === "Cập nhật thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Cập nhật thành công',allowOutsideClick: false}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=posts';}});</script>" : ""?>
<?= (isset($alertUpdate) && $alertUpdate === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<?= (isset($alertDelete) && $alertDelete === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Xóa thành công',allowOutsideClick: false}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=posts';}});</script>" : ""?>
<?= (isset($alertDelete) && $alertDelete === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<!-- Xử lí hiển thị -->