<?php
class User_Controller
{
    private $pdo;
    private $userModel;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->userModel = new User_Model($this->pdo);
    }

    function register()
    {
        $result = $this->userModel->addUser();
        include './views/register.php';
    }

    function active()
    {
        $result = $this->userModel->activeAccount();
        include './views/register.php';
    }

    function login()
    {
        $result = $this->userModel->checkAccount();
        include './views/login.php';
    }

    function forgot()
    {
        $result = $this->userModel->forgotPassword();
        include './views/forgot-password.php';
    }

    function newPass()
    {
        $result = $this->userModel->newPassword();
        include './views/new-password.php';
    }

    function showUserList()
    {
        $result = $this->userModel->showUsers();
        include './users/users.php';
    }

    // Xem thông tin người dùng
    function showUserInfo()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $user = $this->userModel->getUserById($id);
            if ($user) {
                $data = [
                    'user' => $user,
                    'username_err' => '',
                    'email_err' => '',
                    'fullname_err' => '',
                    'phone_err' => '',
                    'address_err' => '',
                    'current_password_err' => '',
                    'new_password_err' => '',
                    'confirm_password_err' => ''
                ];
                include '../admin/users/info.php';
            } else {
                header('Location: ./admin/?room=users&error=not_found');
            }
        } else {
            header('Location: ./admin/?room=users');
        }
    }

    // Cập nhật thông tin người dùng
    function updateUserInfo()
    {
        $result = $this->userModel->updateUserInfo($_POST);
        include '../admin/users/info.php';
    }

    function updateUser()
    {
        $result = $this->userModel->updateStatusOrRole();
    }

    function checkToken()
    {
        $result = $this->userModel->checkToken();
        return $result;
    }

    // Cập nhật mật khẩu người dùng
    function updateUserPassword()
    {
        $result = $this->userModel->updateUserPassword($_POST);
        include '../admin/users/info.php';
    }
}
