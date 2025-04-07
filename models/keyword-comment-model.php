<?php
class Keyword_Comment_Model
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkKeyword($content)
    {
        $sql = "SELECT COUNT(*) FROM keyword_comments WHERE ? LIKE CONCAT('%', keyword, '%')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$content]);
        return $stmt->fetchColumn() > 0;
    }
    public function getAllKeywords()
    {
        $sql = "SELECT * FROM keyword_comments ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addKeyword($keyword)
    {
        try {
            $sql = "INSERT INTO keyword_comments (keyword) VALUES (:keyword)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['keyword' => $keyword]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteKeyword($id)
    {
        try {
            $sql = "DELETE FROM keyword_comments WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkKeywordExists($keyword)
    {
        try {
            $sql = "SELECT COUNT(*) FROM keyword_comments WHERE keyword = :keyword";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['keyword' => $keyword]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}