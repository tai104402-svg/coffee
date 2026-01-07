<?php
require "../config/database.php";

try {
    $db = Database::connect();
    echo "Kết nối database thành công";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
