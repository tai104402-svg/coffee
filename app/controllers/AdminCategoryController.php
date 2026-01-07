<?php

class AdminCategoryController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    // LIST CATEGORY
    public function index() {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY id DESC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/admin/categories/index.php';
    }

    // FORM CREATE
    public function create() {
        require __DIR__ . '/../views/admin/categories/create.php';
    }

    // STORE CATEGORY
    public function store() {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);

        if (!$name) die('Tên category không được để trống');

        $stmt = $this->pdo->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);

        header('Location: /GocCaPhe/public/index.php?url=admin/categories');
        exit;
    }

    // FORM EDIT
    public function edit() {
        $id = $_GET['id'] ?? null;

        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) die('Category không tồn tại');

        require __DIR__ . '/../views/admin/categories/edit.php';
    }

    // UPDATE CATEGORY
    public function update() {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);

        if (!$name) die('Tên category không được để trống');

        $stmt = $this->pdo->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        $stmt->execute([$name, $description, $id]);

        header('Location: /GocCaPhe/public/index.php?url=admin/categories');
        exit;
    }

    // DELETE CATEGORY
    public function delete() {
        $id = $_GET['id'];

        // Bạn có thể thêm kiểm tra xem category có product không trước khi xóa
        $stmtCheck = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id=?");
        $stmtCheck->execute([$id]);
        if ($stmtCheck->fetchColumn() > 0) {
            die('Không thể xóa category còn sản phẩm');
        }

        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id=?");
        $stmt->execute([$id]);

        header('Location: /GocCaPhe/public/index.php?url=admin/categories');
        exit;
    }
}
