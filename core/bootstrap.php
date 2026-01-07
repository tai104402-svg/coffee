<?php
// ========================================
// BOOTSTRAP FILE - SAFE FOR RENDER
// ========================================

// Start session (chỉ 1 lần)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Root path (/var/www/html)
$ROOT_PATH = dirname(__DIR__);

// ========================================
// Composer autoload (OPTIONAL)
// ========================================
$autoload = $ROOT_PATH . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

// ========================================
// Database
// ========================================
require_once $ROOT_PATH . '/config/database.php';

// ========================================
// Middleware
// ========================================
require_once $ROOT_PATH . '/app/middleware/auth.php';

// ========================================
// Controllers
// ========================================
require_once $ROOT_PATH . '/app/controllers/AuthController.php';
require_once $ROOT_PATH . '/app/controllers/HomeController.php';
require_once $ROOT_PATH . '/app/controllers/ReservationController.php';

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
