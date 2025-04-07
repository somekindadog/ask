<?php
class Keyword_Comment_Controller
{
    private $keywordModel;

    public function __construct($db)
    {
        $this->keywordModel = new Keyword_Comment_Model($db);
    }

    public function showKeywords()
    {
        $keywords = $this->keywordModel->getAllKeywords();
        require_once '../admin/keywords/index.php';
    }

    public function addKeyword()
    {
        $keyword = trim($_POST['keyword'] ?? '');
        if (empty($keyword)) {
            $result = "Chưa nhập đầy đủ thông tin";
        } else if ($this->keywordModel->checkKeywordExists($keyword)) {
            $result = "Từ khóa này đã tồn tại";
        } else if ($this->keywordModel->addKeyword($keyword)) {
            $result = "Thành công";
        } else {
            $result = "Lỗi";
        }
        require_once '../admin/keywords/index.php';
    }

    public function deleteKeyword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($this->keywordModel->deleteKeyword($id)) {
                $result = "Thành công";
            } else {
                $result = "Lỗi";
            }
        }
        require_once '../admin/keywords/index.php';
    }
}