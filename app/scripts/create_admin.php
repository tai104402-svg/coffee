<?php
require_once __DIR__ . '/../../core/bootstrap.php';

$pdo = Database::connect();

$name = 'Góc Cà Phê';
$email = 'admin@gmail.com';
$password = '123456';
$role = 'ADMIN';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, :role)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $hashedPassword,
    ':role' => $role
]);

echo "Tạo admin thành công";
