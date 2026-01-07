<?php
ob_start();

// ===== DEBUG (TẮT KHI LÊN PROD) =====
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ===== LOAD BOOTSTRAP =====
require_once __DIR__ . '/../core/bootstrap.php';

// ===== ROUTING =====
$url = $_GET['url'] ?? '';

switch ($url) {

    case '':
        (new HomeController)->index();
        break;

    /* ================= AUTH ================= */
    case 'login':
        (new AuthController)->login();
        break;

    case 'login-handle':
        (new AuthController)->handleLogin();
        break;

    case 'logout':
        (new AuthController)->logout();
        break;

    case 'register':
        (new AuthController)->register();
        break;

    case 'register-handle':
        (new AuthController)->handleRegister();
        break;

    /* ================= USER ================= */
    case 'profile':
        requireLogin();
        (new UserController)->profile();
        break;

    case 'profile/update':
        requireLogin();
        (new UserController)->updateProfile();
        break;

    case 'menu':
        requireLogin();
        (new ProductController)->list();
        break;

    case 'cart':
        requireLogin();
        (new CartController)->index();
        break;

    case 'cart/add':
        requireLogin();
        (new CartController)->add();
        break;

    case 'cart/delete':
        requireLogin();
        (new CartController)->delete();
        break;

    case 'cart/updateQuantity':
        requireLogin();
        (new CartController)->updateQuantity();
        break;

    case 'cart/checkout':
        requireLogin();
        (new CartController)->checkout();
        break;

    /* ================= RESE*
