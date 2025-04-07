<?php
class Banner_Model
{
    private $db;
    function __construct(PDO $db)
    {
        $this->db = $db;
    }
    /* ------------------------------- SHOW BANNER LIST WEB ------------------------------ */
    function showBannerListWeb()
    {
        $status = "display";
        $stmt = $this->db->prepare("SELECT * FROM banners WHERE status = ? LIMIT 3");
        $stmt->bindParam(1, $status);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                return $result;
            }
        }
    }
    /* ------------------------------- SHOW BANNER LIST WEB ------------------------------ */
    /* ------------------------------- SHOW BANNER LIST ------------------------------ */
    function showBannerList()
    {
        $stmt = $this->db->prepare("SELECT * FROM banners");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                return $result;
            }
        }
    }
    /* ------------------------------- SHOW BANNER LIST ------------------------------ */
    /* ------------------------------- ADD BANNER ------------------------------ */
    function addBanner()
    {
        $mess = "";
        $image = isset($_FILES['image']) ? $_FILES['image']['name'] : "";
        $url = isset($_POST["url"]) ? $_POST["url"] : "";
        $description = isset($_POST["description"]) ? $_POST["description"] : "";
        $status = "hidden";

        if (!empty($image) && !empty($url) && !empty($status) && !empty($description)) {
            if (isset($_POST["add-banner"])) {
                $stmt = $this->db->prepare("INSERT INTO banners(`image`,`url`,`description`,`status`) VALUES (?,?,?,?)");
                $stmt->bindParam(1, $image);
                $stmt->bindParam(2, $url);
                $stmt->bindParam(3, $description);
                $stmt->bindParam(4, $status);
                if ($stmt->execute()) {
                    $mess = "Thành công";
                } else {
                    $mess = "Lỗi";
                }
            }
        } else {
            $mess = "Chưa nhập đầy đủ thông tin";
        }
        return $mess;
    }
    /* ------------------------------- ADD BANNER ------------------------------ */
    /* ------------------------------- DATA OLD BANNER ------------------------------ */
    function dataOldBanner()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if (!empty($id) && is_numeric($id)) {
            $stmt = $this->db->prepare("SELECT * FROM banners WHERE id = ?");
            $stmt->bindParam(1, $id);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    return $result[0];
                }
            }
        }
    }
    /* ------------------------------- DATA OLD BANNER ------------------------------ */
    /* ------------------------------- EDIT BANNER ------------------------------ */
    function editBanner()
    {
        $mess = "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $image = isset($_FILES['image']) ? $_FILES['image']['name'] : "";
            if (empty($image)) {
                $image = isset($_POST["imageOld"]) ? $_POST["imageOld"] : "";
            }
            $url = isset($_POST["url"]) ? $_POST["url"] : "";
            $description = isset($_POST["description"]) ? $_POST["description"] : "";

            if (!empty($id) && is_numeric($id) && !empty($image) && !empty($url) && !empty($description)) {
                if (isset($_POST["edit-banner"])) {
                    $stmt = $this->db->prepare("UPDATE banners SET image = ?, url = ?, description = ? WHERE id = ?");
                    $stmt->bindParam(1, $image);
                    $stmt->bindParam(2, $url);
                    $stmt->bindParam(3, $description);
                    $stmt->bindParam(4, $id);
                    if ($stmt->execute()) {
                        $mess = "Thành công";
                    } else {
                        $mess = "Lỗi";
                    }
                }
            } else {
                $mess = "Chưa nhập đầy đủ thông tin";
            }
        }
        return $mess;
    }
    /* ------------------------------- EDIT BANNER ------------------------------ */
    /* ------------------------------- UPDATE BANNER ------------------------------ */
    function updateBanner()
    {
        $mess = "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $status = isset($_GET["status"]) ? $_GET["status"] : "";
        if (!empty($status) && !empty($id) && is_numeric($id)) {
            if ($status === "hidden" || $status === "display") {
                $stmt = $this->db->prepare("UPDATE banners SET status = ? WHERE id = ?");
                $stmt->bindParam(1, $status);
                $stmt->bindParam(2, $id);
                if ($stmt->execute()) {
                    $mess = "Thành công";
                }
            } else {
                $mess = "Lỗi";
            }
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }
    /* ------------------------------- UPDATE BANNER ------------------------------ */
    /* ------------------------------- DELETE BANNER ------------------------------ */
    function deleteBanner()
    {
        $mess = "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if (!empty($id) && is_numeric($id)) {
            $stmt = $this->db->prepare("DELETE FROM banners WHERE id = ?");
            $stmt->bindParam(1, $id);
            if ($stmt->execute()) {
                $mess = "Thành công";
            } else {
                $mess = "Lỗi";
            }
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }
    /* ------------------------------- DELETE BANNER ------------------------------ */

    function countBanners()
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM banners");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    function getActiveBanners()
    {
        $query = $this->db->query("
            SELECT * FROM banners 
            WHERE status = 'active' 
            ORDER BY created_at DESC
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getBannerStats()
    {
        $query = $this->db->query("
            SELECT 
                status,
                COUNT(*) as count
            FROM banners
            GROUP BY status
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>