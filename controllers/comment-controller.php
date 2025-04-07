<?php
class Comment_Controller
{
    private $db;
    private $commentModel;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->commentModel = new Comment_Model($this->db);
    }

    function showComments()
    {
        $result = $this->commentModel->showCommentsList();
        include './comments/comments.php';
    }

    function editComment()
    {
        $dataOld = $this->commentModel->getCommentById($_GET['id']);
        if (isset($dataOld)) {
            $result = $this->commentModel->editComment();
            include_once './comments/edit-comment.php';
        } else {
            header("Location: ../404/");
        }
    }

    function deleteComment()
    {
        $result = $this->commentModel->showCommentsList();
        $alertDelete = $this->commentModel->deleteComment();
        include './comments/comments.php';
    }

    function approveComment()
    {
        $result = $this->commentModel->approveComment();
        include './comments/comments.php';
    }

    function showCommentsAside()
    {
        $comments = $this->commentModel->getRecentComments(5);
        include './public/layout/aside.php';
    }
}
?>