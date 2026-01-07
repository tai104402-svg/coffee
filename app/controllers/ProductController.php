<?php
class ProductController {
    public function list() {
        $db = Database::connect(); // <-- sửa từ getConnection() sang connect()

        // Lấy danh mục
        $stmt = $db->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lọc sản phẩm theo danh mục nếu có
        $category_id = $_GET['category_id'] ?? null;
        if ($category_id) {
            $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                                  FROM products p 
                                  JOIN categories c ON p.category_id = c.id 
                                  WHERE p.category_id = ?");
            $stmt->execute([$category_id]);
        } else {
            $stmt = $db->query("SELECT p.*, c.name as category_name 
                                 FROM products p 
                                 JOIN categories c ON p.category_id = c.id");
        }
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Load view trong user
        require __DIR__ . '/../views/user/product_list.php';
    }
}
