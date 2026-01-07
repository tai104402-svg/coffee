<?php
// ===== CHỐNG LỖI "headers already sent" =====
ob_start();

// ===== BẬT DEBUG (CHỈ DÙNG KHI DEV) =====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===== LOAD BOOTSTRAP (SESSION + AUTOLOAD + CONFIG) =====
require_once __DIR__ . '/../core/bootstrap.php';

// ===== ROUTING =====
$url = $_GET['url'] ?? '';

switch ($url) {

    case '':
        (new HomeController)->index();
        break;

    /* ================= CART ================= */
    case 'cart/add':
        requireLogin();
        (new CartController)->add();
        break;

    case 'cart/checkout':
        requireLogin();
        (new CartController)->checkout();
        break;

    case 'cart/payment':
        requireLogin();
        (new CartController)->payment();
        break;

    case 'cart/count':
        (new CartController)->count();
        break;

    case 'cart/delete':
        requireLogin();
        (new CartController)->delete();
        break;

    case 'cart/updateQuantity':
        requireLogin();
        (new CartController)->updateQuantity();
        break;

    case 'cart':
        requireLogin();
        (new CartController)->index();
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
    case 'menu':
        requireLogin();
        (new ProductController)->list();
        break;

    case 'profile':
        requireLogin();
        (new UserController)->profile();
        break;

    case 'profile/update':
        requireLogin();
        (new UserController)->updateProfile();
        break;

    /* ================= PAGES ================= */
    case 'gioithieu':
        (new PageController)->gioithieu();
        break;

    case 'datban':
        (new HomeController)->datban();
        break;

    /* ================= RESERVATION ================= */
    case 'reservation/create':
        (new ReservationController)->create();
        break;

    case 'reservation/store':
        (new ReservationController)->store();
        break;

    case 'reservation/history':
        (new ReservationController)->history();
        break;

    /* ================= STAFF ================= */
    case 'staff':
        (new StaffController)->index();
        break;

    /* ================= ADMIN - USERS ================= */
    case 'admin':
    case 'admin/users':
        requireRole('ADMIN');
        (new AdminUserController)->index();
        break;

    case 'admin/users/create':
        requireRole('ADMIN');
        (new AdminUserController)->create();
        break;

    case 'admin/users/store':
        requireRole('ADMIN');
        (new AdminUserController)->store();
        break;

    case 'admin/users/edit':
        requireRole('ADMIN');
        (new AdminUserController)->edit();
        break;

    case 'admin/users/update':
        requireRole('ADMIN');
        (new AdminUserController)->update();
        break;

    case 'admin/users/delete':
        requireRole('ADMIN');
        (new AdminUserController)->delete();
        break;

    /* ================= ADMIN - CATEGORIES ================= */
    case 'admin/categories':
        requireRole('ADMIN');
        (new AdminCategoryController)->index();
        break;

    case 'admin/categories/create':
        requireRole('ADMIN');
        (new AdminCategoryController)->create();
        break;

    case 'admin/categories/store':
        requireRole('ADMIN');
        (new AdminCategoryController)->store();
        break;

    case 'admin/categories/edit':
        requireRole('ADMIN');
        (new AdminCategoryController)->edit();
        break;

    case 'admin/categories/update':
        requireRole('ADMIN');
        (new AdminCategoryController)->update();
        break;

    case 'admin/categories/delete':
        requireRole('ADMIN');
        (new AdminCategoryController)->delete();
        break;

    /* ================= ADMIN - PRODUCTS ================= */
    case 'admin/products':
        requireRole('ADMIN');
        (new AdminProductController)->index();
        break;

    case 'admin/products/create':
        requireRole('ADMIN');
        (new AdminProductController)->create();
        break;

    case 'admin/products/store':
        requireRole('ADMIN');
        (new AdminProductController)->store();
        break;

    case 'admin/products/edit':
        requireRole('ADMIN');
        (new AdminProductController)->edit();
        break;

    case 'admin/products/update':
        requireRole('ADMIN');
        (new AdminProductController)->update();
        break;

    case 'admin/products/delete':
        requireRole('ADMIN');
        (new AdminProductController)->delete();
        break;

    /* ================= ADMIN - RESERVATIONS ================= */
    case 'admin/reservations':
        requireStaffOrAdmin();
        (new AdminReservationController)->index();
        break;

    case 'admin/reservations/approve':
        requireStaffOrAdmin();
        (new AdminReservationController)->approve();
        break;

    case 'admin/reservations/cancel':
        requireStaffOrAdmin();
        (new AdminReservationController)->cancel();
        break;

    /* ================= ADMIN - REVENUE ================= */
    case 'admin/revenues':
        requireRole('ADMIN');
        (new AdminRevenueController)->index();
        break;

    /* ================= ORDERS ================= */
    case 'admin/orders':
        requireStaffOrAdmin();
        (new OrderController)->index();
        break;

    case 'admin/orders/approve':
        requireStaffOrAdmin();
        (new OrderController)->approve();
        break;

    case 'admin/orders/reject':
        requireStaffOrAdmin();
        (new OrderController)->reject();
        break;

    /* ================= 404 ================= */
    default:
        http_response_code(404);
        echo '404 - Không tìm thấy trang';
        break;
}
