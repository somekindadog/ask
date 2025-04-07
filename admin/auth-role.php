<?php
session_start();
include '../models/user-model.php';
include '../controllers/user-controller.php';
$pdo = require '../config/database.php'; // Sử dụng PDO thay vì MySQLi
$check = new User_Controller($pdo);
$checkToken = $check->checkToken(); // Phòng trường hợp người dùng tạo session với role admin bên 1 phiên khác ko liên quan ==> check token
$CHECK_ID = isset($_SESSION["user"]) ? $_SESSION["user"]['id'] : "";
$user = (new User_Model($pdo))->find($CHECK_ID);
$CHECK_ROLE = $user['role'];

if($checkToken !== "successtoken" || empty($CHECK_ID) || empty($CHECK_ROLE)){ // Kiểm tra token + id + role => Đã đăng nhập chưa
    header("Location: ../404/");
}else{ // Nếu như đã token đã được check hợp lệ
    if($CHECK_ROLE === 'admin' || $CHECK_ROLE === 'staff'){ // Kiểm tra quyền
    }else{
        header("Location: ../404/");
    }
}
?>