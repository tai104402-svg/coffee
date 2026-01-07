<?php

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /?url=login");
        exit;
    }
}

function requireRole($role) {
    requireLogin();

    $userRole = strtoupper($_SESSION['user']['role'] ?? '');
    $role = strtoupper($role);

    if ($userRole !== $role) {
        http_response_code(403);
        echo "Bạn không có quyền truy cập";
        exit;
    }
}

function requireStaffOrAdmin() {
    requireLogin();

    $role = strtoupper($_SESSION['user']['role'] ?? '');

    if (!in_array($role, ['ADMIN', 'STAFF'])) {
        http_response_code(403);
        echo "Bạn không có quyền truy cập";
        exit;
    }
}
