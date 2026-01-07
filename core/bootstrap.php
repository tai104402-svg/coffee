<?php
session_start();

// ========================================
// BOOTSTRAP FILE - FIX FOR RENDER + DOCKER
// ========================================

//require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/database.php';
// KHÔNG cho phép output trước session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đường dẫn gốc project (/var/www/html)
$ROOT_PATH = dirname(__DIR__);

// ========================================
// Database
// ========================================
require_once $ROOT_PATH . '/config/database.php';

// ========================================
// Middleware
// ========================================
require_once $ROOT_PATH . '/app/middleware/auth.php';

// ========================================
// Controllers - Auth & Home
// ========================================
require_once $ROOT_PATH . '/app/controllers/AuthController.php';
require_once $ROOT_PATH . '/app/controllers/HomeController.php';

// ========================================
// Controllers - User
// ========================================
require_once $ROOT_PATH . '/app/controllers/ReservationController.php';

// ========================================
// Controllers - Admin
// ========================================
require_once $ROOT_PATH . '/app/controllers/AdminUserController.php';
require_once $ROOT_PATH . '/app/controllers/AdminCategoryController.php';
require_once $ROOT_PATH . '/app/controllers/ProductController.php';
require_once $ROOT_PATH . '/app/controllers/CartController.php';
require_once $ROOT_PATH . '/app/controllers/AdminRevenueController.php';
require_once $ROOT_PATH . '/app/controllers/PageController.php';
require_once $ROOT_PATH . '/app/controllers/UserController.php';
require_once $ROOT_PATH . '/app/controllers/OrderController.php';

require_once $ROOT_PATH . '/app/controllers/AdminProductController.php';
require_once $ROOT_PATH . '/app/controllers/AdminReservationController.php';
require_once $ROOT_PATH . '/app/controllers/AdminStaffController.php';
require_once $ROOT_PATH . '/app/controllers/StaffController.php';
