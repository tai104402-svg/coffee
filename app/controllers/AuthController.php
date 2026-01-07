<?php

class AuthController {

    // ================= LOGIN =================
    public function login() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function handleLogin() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=login');
            exit;
        }

        // 1️⃣ Lấy dữ liệu form và trim
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ email và mật khẩu';
            header('Location: /?url=login');
            exit;
        }

        // 2️⃣ Start session nếu chưa start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 3️⃣ Kết nối DB
        $pdo = Database::connect();

        // 4️⃣ Lấy user theo email (lowercase để tránh case-sensitive)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(email) = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng';
            header('Location: /?url=login');
            exit;
        }

        // 5️⃣ Kiểm tra password
        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng';
            header('Location: /?url=login');
            exit;
        }

        // 6️⃣ Không lưu password trong session
        unset($user['password']);
        $_SESSION['user'] = $user;

        // 7️⃣ Redirect theo role
        $role = strtoupper($user['role'] ?? 'USER');

        switch ($role) {
            case 'ADMIN':
                header("Location: /?url=admin");
                break;
            case 'STAFF':
                header("Location: /?url=staff");
                break;
            default:
                header("Location: /");
        }
        exit;
    }

    // ================= REGISTER =================
    public function register() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function handleRegister() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/\.com$/', $email)) {
            $_SESSION['error'] = 'Email phải đúng định dạng và kết thúc bằng .com';
            header('Location: /?url=register');
            exit;
        }

        if ($name === '' || $password === '' || $passwordConfirm === '') {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: /?url=register');
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Mật khẩu nhập lại không khớp';
            header('Location: /?url=register');
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Mật khẩu phải từ 8 ký tự trở lên';
            header('Location: /?url=register');
            exit;
        }

        $pdo = Database::connect();

        $stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(email) = :email");
        $stmt->execute(['email' => strtolower($email)]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Email đã tồn tại';
            header('Location: /?url=register');
            exit;
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users (name, email, password, role)
             VALUES (:name, :email, :password, 'USER')"
        );
        $stmt->execute([
            'name' => $name,
            'email' => strtolower($email),
            'password' => $hashPassword
        ]);

        $_SESSION['success'] = 'Đăng ký thành công, vui lòng đăng nhập';
        header('Location: /?url=login');
        exit;
    }

    // ================= LOGOUT =================
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: /?url=login");
        exit;
    }
}
