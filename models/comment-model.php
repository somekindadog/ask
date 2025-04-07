<?php
class Comment_Model
{
    private $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /* --------------------------- SHOW COMMENTS LIST -------------------------- */
    function showCommentsList()
    {
        $sql = "SELECT c.*, u.userName, p.productName 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* --------------------------- GET COMMENT BY ID -------------------------- */
    function getCommentById($id)
    {
        $sql = "SELECT c.*, u.userName, p.productName 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                WHERE c.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* --------------------------- EDIT COMMENT -------------------------- */
    function editComment()
    {
        $mess = "";
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["edit-comment"])) {
                $id = $_GET["id"];
                $content = $_POST["content"];

                if (!empty($id) && !empty($content)) {
                    $sql = "UPDATE comments SET content = :content WHERE id = :id";
                    $stmt = $this->pdo->prepare($sql);
                    if ($stmt->execute(['content' => $content, 'id' => $id])) {
                        $mess = "Thành công";
                    } else {
                        $mess = "Lỗi";
                    }
                } else {
                    $mess = "Chưa nhập đầy đủ thông tin";
                }
            }
        }
        return $mess;
    }

    /* --------------------------- DELETE COMMENT -------------------------- */
    function deleteComment()
    {
        $mess = "";
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if (!empty($id)) {
            $sql = "DELETE FROM comments WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute(['id' => $id])) {
                $mess = "Thành công";
            } else {
                $mess = "Lỗi";
            }
        }
        return $mess;
    }

    /* --------------------------- APPROVE COMMENT -------------------------- */
    function approveComment()
    {
        $mess = "";
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["approve-comment"])) {
                $id = $_POST["id"];
                $status = $_POST["status"];

                if (!empty($id)) {
                    $sql = "UPDATE comments SET status = :status WHERE id = :id";
                    $stmt = $this->pdo->prepare($sql);
                    if ($stmt->execute(['status' => $status, 'id' => $id])) {
                        $mess = "Thành công";
                    } else {
                        $mess = "Lỗi";
                    }
                }
            }
        }
        return $mess;
    }

    /* --------------------------- COUNT COMMENTS -------------------------- */
    function countComments()
    {
        $query = $this->pdo->query("SELECT COUNT(*) as total FROM comments");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /* --------------------------- GET RECENT COMMENTS -------------------------- */
    function getRecentComments($limit = 5)
    {
        $sql = "SELECT c.*, u.userName, p.productName 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC 
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* --------------------------- GET PENDING COMMENTS -------------------------- */
    function getPendingComments()
    {
        $sql = "SELECT c.*, u.userName, p.productName 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                WHERE c.status = 'pending' 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getByPostId($postId)
    {
        // Lấy user, lấy post
        $sql = "SELECT c.*, u.userName 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = :id AND c.status = :status
                ORDER BY c.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $postId,
            'status' => 'approved'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // thêm bình luậnfunction addComment($data, $db)
    function addComment($data, $db)
    {
        $keyword = (new Keyword_Comment_Model($db))->checkKeyword($data['content']);
        $status = $keyword ? 'pending' : 'approved';
        $sql = "INSERT INTO comments (user_id, post_id, content, status) VALUES (:user_id, :post_id, :content, :status)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'user_id' => $_SESSION['user']['id'],
            'post_id' => $data['post_id'],
            'content' => $data['content'],
            'status' => $status
        ]);
        return "Thêm mới bình luận thành công";
    }
}

?>