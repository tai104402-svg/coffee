<?php

class AdminUserController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    // LIST USER
    public function index() {
        $stmt = $this->pdo->query("SELECT id, name, email, role FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/admin/users/index.php';
    }

    // FORM CREATE
    public function create() {
        require __DIR__ . '/../views/admin/users/create.php';
    }

    // STORE USER
    public function store() {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (!$name || !$email || !$password || !$role) {
            die('Thiếu dữ liệu');
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password, role)
             VALUES (:name, :email, :password, :role)"
        );

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ]);

        header('Location: /GocCaPhe/public/index.php?url=admin/users');
        exit;
    }

    // FORM EDIT
    public function edit() {
        $id = $_GET['id'] ?? null;

        $stmt = $this->pdo->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) die('User không tồn tại');

        require __DIR__ . '/../views/admin/users/edit.php';
    }

    // UPDATE USER
    public function update() {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'] ?? '';

        if ($password) {
            $sql = "UPDATE users SET name=?, email=?, role=?, password=? WHERE id=?";
            $params = [$name, $email, $role, password_hash($password, PASSWORD_DEFAULT), $id];
        } else {
            $sql = "UPDATE users SET name=?, email=?, role=? WHERE id=?";
            $params = [$name, $email, $role, $id];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        header('Location: /GocCaPhe/public/index.php?url=admin/users');
        exit;
    }

    // DELETE USER
    public function delete() {
        $id = $_GET['id'];

        if ($id == $_SESSION['user']['id']) {
            die('Không thể xóa chính mình');
        }

        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: /GocCaPhe/public/index.php?url=admin/users');
        exit;
    }
}
