<?php

class AdminProductController {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    // LIST PRODUCTS
    public function index() {
        // Lấy product kèm tên category
        $stmt = $this->pdo->query(
            "SELECT p.*, c.name AS category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.id DESC"
        );
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/admin/products/index.php';
    }

    // FORM CREATE
    public function create() {
        // Lấy danh sách category để chọn
        $stmt = $this->pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/admin/products/create.php';
    }

    // STORE PRODUCT
    public function store() {
        $name = trim($_POST['name']);
        $price = (int)$_POST['price'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'AVAILABLE';
        $image = $_FILES['image']['name'] ?? '';

        if (!$name || !$price || !$category_id) die('Thiếu dữ liệu bắt buộc');

        // Upload image nếu có
        if ($image) {
            $target_dir = __DIR__ . '/../../public/assets/img/';
            move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO products (category_id, name, price, image, description, status)
             VALUES (:category_id, :name, :price, :image, :description, :status)"
        );
        $stmt->execute([
            'category_id' => $category_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'description' => $description,
            'status' => $status
        ]);

        header('Location: /GocCaPhe/public/index.php?url=admin/products');
        exit;
    }

    // FORM EDIT
    public function edit() {
        $id = $_GET['id'] ?? null;

        // Lấy product
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) die('Product không tồn tại');

        // Lấy category list
        $stmt = $this->pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/products/edit.php';
    }

    // UPDATE PRODUCT
    public function update() {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $price = (int)$_POST['price'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'AVAILABLE';
        $image = $_FILES['image']['name'] ?? '';

        if (!$name || !$price || !$category_id) die('Thiếu dữ liệu bắt buộc');

        if ($image) {
            $target_dir = __DIR__ . '/../../public/assets/img/';
            move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
            $stmt = $this->pdo->prepare(
                "UPDATE products SET category_id=?, name=?, price=?, image=?, description=?, status=? WHERE id=?"
            );
            $stmt->execute([$category_id, $name, $price, $image, $description, $status, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE products SET category_id=?, name=?, price=?, description=?, status=? WHERE id=?"
            );
            $stmt->execute([$category_id, $name, $price, $description, $status, $id]);
        }

        header('Location: /GocCaPhe/public/index.php?url=admin/products');
        exit;
    }

    // DELETE PRODUCT
    public function delete() {
        $id = $_GET['id'];
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id=?");
        $stmt->execute([$id]);

        header('Location: /GocCaPhe/public/index.php?url=admin/products');
        exit;
    }
}
