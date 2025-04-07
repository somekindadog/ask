<?php
class Product_Model
{
    private $db;
    function __construct(PDO $db)
    {
        $this->db = $db;
    }
    /* ---------------------------- SHOW PRODUCT LIST --------------------------- */
    function showProductList()
    {
        $stmt = $this->db->prepare("SELECT * FROM posts");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    /* ---------------------------- SHOW PRODUCT LIST --------------------------- */
    /* ---------------------------- SHOW PRODUCT LIST OPTION --------------------------- */
    function showProductListByCategory($categoryId)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE categoryId = ?");
        $stmt->execute([$categoryId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /* ---------------------------- SHOW PRODUCT LIST OPTION --------------------------- */
    /* ---------------------------- ADD PRODUCT --------------------------- */
    function createProduct()
    {
        $mess = "";

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["add-product"])) {
                $categoryId = $_POST["categoryId"];
                $productName = $_POST["productName"];
                $details = $_POST["details"];
                $status = "none";

                // Xử lý upload ảnh
                $image = $_FILES['image']['name'];
                $uploadOk = 1;
                // Kiểm tra xem tệp có phải là hình ảnh thực sự hay không
                if (isset($_POST["add-product"])) {
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $mess = "File không phải là ảnh.";
                        $uploadOk = 0;
                    }
                }
                // Kiểm tra nếu $uploadOk bị lỗi
                if ($uploadOk == 0) {
                    $mess = "Xin lỗi, tệp của bạn không được tải lên.";
                    // Nếu mọi thứ đều ổn, cố gắng tải lên tệp
                } else {
                    $target_dir = "../uploads/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    // Tạo thư mục nếu nó không tồn tại
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // Tải ảnh lên thành công, tiến hành thêm thông tin bài viết vào cơ sở dữ liệu
                        $stmt = $this->db->prepare("INSERT INTO posts(`categoryId`, `image`,`productName`,`details`,`status`)VALUES (?,?,?,?,?) ");
                        $stmt->execute([$categoryId, $image, $productName, $details, $status]);
                        $mess = "Thành công";
                    } else {
                        $mess = "Đã xảy ra lỗi khi tải ảnh lên.";
                    }
                }
            }
        }
        return $mess;
    }
    /* ---------------------------- ADD PRODUCT --------------------------- */
    /* ---------------------------- EDIT PRODUCT --------------------------- */
    /* ---------------------------- EDIT PRODUCT --------------------------- */
    function editProduct()
    {
        $mess = "";
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["edit-product"])) {
                $id = (isset($_GET["id"])) ? $_GET["id"] : "";
                $categoryId = $_POST["categoryId"];
                $productName = $_POST["productName"];
                $details = $_POST["details"];
                $status = "none";

                // Xử lý upload ảnh nếu có ảnh mới
                if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                    $target_dir = "../uploads/"; // Thư mục lưu trữ ảnh đã upload
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);

                    // Tạo thư mục nếu nó không tồn tại
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // Tải ảnh lên thành công, tiến hành cập nhật thông tin bài viết vào cơ sở dữ liệu với ảnh mới
                        $stmt = $this->db->prepare("UPDATE posts SET categoryId = ?, image = ?, productName = ?, details = ?, status = ? WHERE id = ?");
                        $stmt->execute([$categoryId, basename($_FILES["image"]["name"]), $productName, $details, $status, $id]);
                        $mess = "Thành công";
                    } else {
                        $mess = "Đã xảy ra lỗi khi tải ảnh lên.";
                    }
                } else {
                    // Sử dụng ảnh cũ nếu không có ảnh mới được tải lên
                    $stmt = $this->db->prepare("SELECT image FROM posts WHERE id = ?");
                    $stmt->execute([$id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $image = $row['image'];

                    // Tiến hành cập nhật thông tin bài viết vào cơ sở dữ liệu với ảnh cũ
                    $stmt = $this->db->prepare("UPDATE posts SET categoryId = ?, image = ?, productName = ?, details = ?, status = ? WHERE id = ?");
                    $stmt->execute([$categoryId, $image, $productName, $details, $status, $id]);
                    $mess = "Thành công";
                }
            }
        }
        return $mess;
    }
    /* ---------------------------- EDIT PRODUCT --------------------------- */


    /* ---------------------------- EDIT PRODUCT --------------------------- */
    /* ---------------------------- DATA PRODUCT OLD --------------------------- */
    function dataProductOld()
    {
        $id = (isset($_GET["id"])) ? $_GET["id"] : "";
        if (!empty($id)) {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    /* ---------------------------- DATA PRODUCT OLD --------------------------- */
    /* ----------------------------- DELETE PRODUCT ----------------------------- */
    function deleteProduct()
    {
        $mess = "";
        $id = (isset($_GET["id"])) ? $_GET["id"] : "";
        if (!empty($id)) {
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $mess = "Thành công";
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }
    /* ----------------------------- DELETE PRODUCT ----------------------------- */
    /* ----------------------------- UPDATE STATUS PRODUCT ----------------------------- */
    function updateStatusProduct()
    {
        $mess = "";
        $id = (isset($_GET["id"])) ? $_GET["id"] : "";
        $action = (isset($_POST["action"])) ? $_POST["action"] : "";
        if (isset($action)) {
            if (!empty($id) && is_numeric($id) && !empty($action)) {
                $stmt = $this->db->prepare("UPDATE posts SET status = ? WHERE id = ?");
                $stmt->execute([$action, $id]);
                $mess = "Cập nhật thành công";
            } else {
                $mess = "Lỗi";
            }
        }
        return $mess;
    }
    /* ----------------------------- UPDATE STATUS PRODUCT ----------------------------- */
    /* ----------------------------- DETAILS PRODUCT ----------------------------- */
    function detailsProduct()
    {
        $mess = "";
        $id = (isset($_GET["id"])) ? $_GET["id"] : "";
        if (isset($id) && !empty($id)) {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $mess = "Lỗi";
                return $mess;
            }
        } else {
            $mess = "Lỗi";
            return $mess;
        }
    }
    /* ----------------------------- DETAILS PRODUCT ----------------------------- */
    /* ----------------------------- FILTER PRODUCT ----------------------------- */
    function filterProduct()
    {
        $mess = "";
        $categoryId = (isset($_GET["categoryId"])) ? $_GET["categoryId"] : "";
        if (!empty($categoryId)) {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE categoryId = ?");
            $stmt->execute([$categoryId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    /* ----------------------------- FILTER PRODUCT ----------------------------- */


    /* ----------------------------- SHOW 1 LIST IMAGE MORE ----------------------------- */
    function showAListImageMore()
    {
        $mess = "Lỗi";
        $productId = (isset($_GET["productId"])) ? $_GET["productId"] : "";
        if (!empty($productId) && is_numeric($productId)) {
            $stmt = $this->db->prepare("SELECT * FROM images WHERE productId = ?");
            $stmt->execute([$productId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $mess = "Lỗi";
            return $mess;
        }
    }
    /* ----------------------------- SHOW 1 LIST IMAGE MORE ----------------------------- */
    /* ----------------------------- DELETE IMAGE MORE ----------------------------- */
    function deleteImageMore()
    {
        $mess = "";
        $image = (isset($_GET["image"])) ? $_GET["image"] : "";
        if (!empty($image)) {
            $stmt = $this->db->prepare("DELETE FROM images WHERE image = ?");
            $stmt->execute([$image]);
            $mess = "Thành công";
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }
    /* ----------------------------- DELETE IMAGE MORE ----------------------------- */
    /* ----------------------- SELECT BY STATUS AND LIMIT ----------------------- */
    function showProductByStatusLimit($status, $limit)
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE status = ? LIMIT $limit");
        $stmt->execute([$status]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /* ----------------------- SELECT BY STATUS AND LIMIT ----------------------- */
    /* ------------------------------- SEARCH NEW ------------------------------- */
    function searchhh()
    {
        $keyword = '%' . $_POST["keyword"] . '%';
        if (isset($_POST["search"])) {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE productName LIKE ?");
            $stmt->execute(array($keyword));
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                return $result;
            }
        }
    }
    /* ------------------------------- SEARCH NEW ------------------------------- */

    function countPosts()
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM posts");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    function getRecentPosts($limit = 5)
    {
        $query = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            ORDER BY p.created_at DESC 
            LIMIT ?
        ");
        $query->execute([$limit]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPostsByStatus($status)
    {
        $query = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.status = ?
            ORDER BY p.created_at DESC
        ");
        $query->execute([$status]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPostsByCategory($categoryId)
    {
        $query = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id = ?
            ORDER BY p.created_at DESC
        ");
        $query->execute([$categoryId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function searchPosts($keyword)
    {
        $query = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM posts p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.title LIKE ? OR p.content LIKE ?
            ORDER BY p.created_at DESC
        ");
        $keyword = "%{$keyword}%";
        $query->execute([$keyword, $keyword]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findPost($id)
    {
        $sql = "SELECT * FROM posts where id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC)[0];
    }

}

