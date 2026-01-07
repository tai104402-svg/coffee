<?php

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /GocCaPhe/public/index.php?url=login");
        exit;
    }
}

function requireRole($role) {
    requireLogin();

    if ($_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        echo "Bạn không có quyền truy cập";
        exit;
    }
}
function requireStaffOrAdmin()
{
    if (!isset($_SESSION['user'])) {
        header('Location: ?url=login');
        exit;
    }

    $role = $_SESSION['user']['role'] ?? '';

    if (!in_array($role, ['ADMIN', 'STAFF'])) {
        http_response_code(403);
        echo "Bạn không có quyền truy cập";
        exit;
    }
}