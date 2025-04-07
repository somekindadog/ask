<?php
class Category_Model
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /* --------------------------- SHOW CATEGORIES LIST -------------------------- */
    function showCategoriesList()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /* --------------------------- SHOW CATEGORIES LIST -------------------------- */

    /* --------------------------- CREATE CATEGORIES -------------------------- */
    function createCategory()
    {
        $mess = "";
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["add-category"])) {
                $categoryName = $_POST["categoryName"];
                $description = $_POST["description"];

                if (!empty($categoryName) && !empty($description)) {
                    $stmt = $this->pdo->prepare("INSERT INTO categories (`categoryName`,`description`) VALUES (?,?)");
                    $stmt->execute([$categoryName, $description]);
                    $mess = "Thành công";
                } else {
                    $mess = "Chưa nhập đầy đủ thông tin";
                }
            }
        }
        return $mess;
    }
    /* --------------------------- CREATE CATEGORIES -------------------------- */

    /* --------------------------- DATA CATEGORY OLD -------------------------- */
    function dataCategoryOld()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if (!empty($id)) {
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
    }
    /* --------------------------- DATA CATEGORY OLD -------------------------- */

    /* --------------------------- EDIT CATEGORY -------------------------- */
    function editCategory()
    {
        $mess = "";
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["edit-category"])) {
                $id = $_GET["id"];
                $categoryName = $_POST["categoryName"];
                $description = $_POST["description"];

                if (!empty($id) && !empty($categoryName) && !empty($description)) {
                    $stmt = $this->pdo->prepare("UPDATE categories SET categoryName = ?, description = ? WHERE id = ?");
                    $stmt->execute([$categoryName, $description, $id]);
                    $mess = "Thành công";
                } else {
                    $mess = "Chưa nhập đầy đủ thông tin";
                }
            }
        }
        return $mess;
    }
    /* --------------------------- EDIT CATEGORY -------------------------- */

    /* --------------------------- DELETE CATEGORY -------------------------- */
    function deleteCategory()
    {
        $mess = "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if (!empty($id)) {
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $mess = "Thành công";
        }
        return $mess;
    }
    /* --------------------------- DELETE CATEGORY -------------------------- */

    function countCategories()
    {
        $query = $this->pdo->query("SELECT COUNT(*) as total FROM categories");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    function getCategoryStats()
    {
        $query = $this->pdo->query("
            SELECT 
                c.id,
                c.name,
                COUNT(p.id) as post_count
            FROM categories c
            LEFT JOIN posts p ON c.id = p.category_id
            GROUP BY c.id
            ORDER BY post_count DESC
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCategoryWithPosts($categoryId)
    {
        $query = $this->pdo->prepare("
            SELECT 
                c.*,
                COUNT(p.id) as total_posts,
                MAX(p.created_at) as last_post_date
            FROM categories c
            LEFT JOIN posts p ON c.id = p.category_id
            WHERE c.id = ?
            GROUP BY c.id
        ");
        $query->execute([$categoryId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
?>