<?php
// Cấu hình SendMail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User_Model
{
    private $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /* -------------------------------- ADD USER -------------------------------- */
    function addUser()
    { // đăng  ký
        session_start();
        $mess = "";

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["register"])) {
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmpassword = $_POST["confirmpassword"];
                $status = 'active';
                $role = 'user';
                $token = bin2hex(random_bytes(40)); // chuỗi nhị phân ngẫu nhiên

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirmpassword)) { // Kiểm tra xem có rỗng không
                        if ($confirmpassword === $password) { // Kiểm tra mật khẩu trùng khớp không
                            $check_email = $this->pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
                            $check_email->execute([$email]);
                            $result = $check_email->fetch(PDO::FETCH_ASSOC);
                            if ($result) {
                                $mess = "Tài khoản đã được đăng ký";
                            } else {
                                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                                $create_account = $this->pdo->prepare(" INSERT INTO users(`token`,`userName`,`email`,`password`,`role`,`status`) VALUES (?,?,?,?,?,?)");
                                $create_account->execute([$token, $username, $email, $password_hash, $role, $status]);
                                if ($create_account->rowCount() > 0) {
                                    $mess = 'Thành công';
                                }
                            }
                        } else {
                            $mess = "Mật khẩu không khớp";
                        }
                    } else {
                        $mess = "Chưa nhập đầy đủ thông tin";
                    }
                } else {
                    $mess = "Định dạng Email không hợp lệ";
                }
            }
        }
        return $mess;
    }
    /* -------------------------------- ADD USER -------------------------------- */
    /* --------------------------- CHECK ACCOUNT LOGIN -------------------------- */
    function checkAccount()
    { // login
        $mess = "";

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if (isset($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];

                if (!empty($email) && !empty($password)) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (!empty($email) && !empty($password)) {
                            $check_email = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
                            $check_email->execute([$email]);
                            $result = $check_email->fetch(PDO::FETCH_ASSOC);
                            if ($result) {
                                $status = $result['status'];
                                if ($status === 'no active') {
                                    $mess = "Tài khoản của bạn chưa được kích hoạt";
                                } elseif ($status === 'disable') {
                                    $mess = "Tài khoản của bạn đã bị vô hiệu hóa";
                                } elseif ($status === 'active') {
                                    $clean_password = htmlspecialchars($password); // Clean password
                                    $db_password = $result['password'];
                                    if (password_verify($clean_password, $db_password)) { // Check password
                                        session_start();
                                        $userId = $result['id'];
                                        $_SESSION['user']['token'] = $result['token'];
                                        $_SESSION['user']['role'] = $result['role']; // quyền
                                        $_SESSION["user"]['id'] = $userId;
                                        header("Location: ../?page=home");
                                    } else {
                                        $mess = "Mật khẩu sai";
                                    }
                                } else {
                                    $mess = "Tài khoản của bạn bị lỗi";
                                }
                            } else {
                                $mess = "Tài khoản chưa được đăng ký";
                            }
                        }
                    } else {
                        $mess = "Định dạng Email không hợp lệ";
                    }
                } else {
                    $mess = "Chưa nhập đầy đủ thông tin";
                }
            }
        }
        return $mess;
    }
    /* --------------------------- CHECK ACCOUNT LOGIN -------------------------- */
    function checkToken()
    {
        $mess = "";
        if (!isset($_SESSION["user"])) {
            session_start();
        }
        $token = (isset($_SESSION["user"])) ? $_SESSION["user"]['token'] : "";
        if (isset($_SESSION["user"]["token"]) && !empty($token)) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token = ?");
            if ($stmt->execute([$token])) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $mess = "successtoken";
                } else {
                    $mess = "Lỗi";
                }
            } else {
                $mess = "Lỗi";
            }
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }
    /* --------------------------- SHOW USER -------------------------- */
    function showUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        }
    }
    /* --------------------------- SHOW USER -------------------------- */
    /* --------------------------- UPDATE USER -------------------------- */
    function updateStatusOrRole()
    {
        $mess = "";
        $action = isset($_POST["action"]) ? $_POST["action"] : "";
        $id = isset($_POST["id"]) ? $_POST["id"] : "";

        // Nếu là update status
        if ($action === 'active' || $action === 'disable') {
            $stmt = $this->pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            if ($stmt->execute([$action, $id])) {
                $mess = "Thành công";
            } else {
                $mess = "Lỗi";
            }
        }

        // Nếu là update role
        if ($action === 'user' || $action === 'staff') {
            $stmt = $this->pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            if ($stmt->execute([$action, $id])) {
                $mess = "Thành công";
            } else {
                $mess = "Lỗi";
            }
        }
        return $mess;
    }
    /* --------------------------- UPDATE USER -------------------------- */

    /* --------------------------- FIND USER -------------------------- */
    function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = $id");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result[0];
            }
        }
    }
    /* --------------------------- FIND USER -------------------------- */

    function countUsers()
    {
        $query = $this->pdo->query("SELECT COUNT(*) as total FROM users");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    function getRecentUsers($limit = 5)
    {
        $query = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT ?");
        $query->execute([$limit]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function lockUser($userId, $duration = 24)
    {
        $lockedUntil = date('Y-m-d H:i:s', strtotime("+{$duration} hours"));
        $query = $this->pdo->prepare("UPDATE users SET status = 'locked', locked_until = ? WHERE id = ?");
        return $query->execute([$lockedUntil, $userId]);
    }

    function unlockUser($userId)
    {
        $query = $this->pdo->prepare("UPDATE users SET status = 'active', locked_until = NULL WHERE id = ?");
        return $query->execute([$userId]);
    }

    function getUserActivity($userId)
    {
        $query = $this->pdo->prepare("
            SELECT 
                'login' as activity_type,
                login_time as activity_time,
                ip_address
            FROM user_activity_logs 
            WHERE user_id = ? 
            ORDER BY activity_time DESC
        ");
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin user theo id
    function getUserById($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật thông tin user
    function updateUserInfo($data)
    {
        $mess = "";
        $id = $data['id'] ?? null;
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';

        if (!$id) {
            $mess = "Lỗi";
            return $mess;
        }

        // Validate thông tin
        if (empty($username)) {
            $mess = "Chưa nhập đầy đủ thông tin";
            return $mess;
        }

        if (empty($email)) {
            $mess = "Chưa nhập đầy đủ thông tin";
            return $mess;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mess = "Email không hợp lệ";
            return $mess;
        }

        // Kiểm tra username và email đã tồn tại chưa
        $existing_user = $this->getUserByUsername($username);
        if ($existing_user && $existing_user['id'] != $id) {
            $mess = "Tên đăng nhập đã tồn tại";
            return $mess;
        }

        $existing_email = $this->getUserByEmail($email);
        if ($existing_email && $existing_email['id'] != $id) {
            $mess = "Email đã tồn tại";
            return $mess;
        }

        // Cập nhật thông tin
        $sql = "UPDATE users SET userName = :username, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $mess = "Thành công";
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }


    // Cập nhật mật khẩu user
    function updateUserPassword($data)
    {
        $mess = "";
        $id = $data['id'] ?? null;
        $current_password = $data['current_password'] ?? '';
        $new_password = $data['new_password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';

        if (!$id) {
            $mess = "Lỗi";
            return $mess;
        }

        // Validate mật khẩu
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $mess = "Chưa nhập đầy đủ thông tin";
            return $mess;
        }

        if (strlen($new_password) < 6) {
            $mess = "Mật khẩu mới phải có ít nhất 6 ký tự";
            return $mess;
        }

        if ($new_password !== $confirm_password) {
            $mess = "Mật khẩu xác nhận không khớp";
            return $mess;
        }

        // Kiểm tra mật khẩu hiện tại
        $user = $this->getUserById($id);
        if (!$user || !password_verify($current_password, $user['password'])) {
            $mess = "Mật khẩu hiện tại không chính xác";
            return $mess;
        }

        // Cập nhật mật khẩu
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $mess = "Thành công";
        } else {
            $mess = "Lỗi";
        }
        return $mess;
    }

    public function getUserByUsername($username)
    {
        try {
            $sql = "SELECT * FROM users WHERE userName = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}