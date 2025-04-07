<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'baomoivn';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Thiết lập chế độ lỗi PDO để báo cáo các lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Xử lý lỗi kết nối
    die("Kết nối database thất bại: " . $e->getMessage());
}

return $pdo;
