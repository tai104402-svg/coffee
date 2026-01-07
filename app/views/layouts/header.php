<?php
require_once __DIR__ . '/../../../core/bootstrap.php';
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? null;
$current_url = $_GET['url'] ?? 'index';

/* ================= BASE URL AUTO ================= */
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
    ? "https"
    : "http") . "://" . $_SERVER['HTTP_HOST'];

/* ================= CART ================= */
$cartCount = 0;
if ($user && $role === 'USER') {
    $cartCount = CartController::getCartCount($user['id']);
}

/* ================= AVATAR ================= */
$avatarPath = $base_url . '/assets/images/default-avatar.png';
if ($user && !empty($user['avatar'])) {
    $avatarPath = $base_url . '/' . $user['avatar'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Góc Cà Phê</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ===== CSS GLOBAL (Render compatible) ===== -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/trangchu.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/introduce.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>


<body>

<header class="header">
    <div class="header-container">

        <!-- LOGO -->
        <div class="logo">
            <a href="/">
                ☕ Góc Cà Phê
            </a>
        </div>

        <!-- MENU -->
        <nav class="nav-menu">
    <a href="/"
       class="<?= ($current_url == 'index') ? 'active' : '' ?>">
        Trang chủ
    </a>

    <a href="/?url=menu"
       class="<?= ($current_url == 'menu') ? 'active' : '' ?>">
        Sản phẩm
    </a>

    <a href="/?url=datban"
       class="<?= ($current_url == 'datban') ? 'active' : '' ?>">
        Đặt bàn
    </a>

    <a href="/?url=gioithieu"
       class="<?= ($current_url == 'gioithieu') ? 'active' : '' ?>">
        Giới thiệu
    </a>
</nav>

        <!-- USER -->
        <div class="nav-user">

            <?php if ($role === 'USER'): ?>
                <a href="/?url=cart" class="btn-cart">
                    🛒 Giỏ hàng
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count" id="cart-count"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>

            <?php elseif ($role === 'STAFF'): ?>
                <a href="/?url=staff" class="btn-cart">
                    Nhân viên
                </a>

            <?php elseif ($role === 'ADMIN'): ?>
                <span>Admin Panel</span>
            <?php endif; ?>

            <?php if ($user): ?>
                <div class="user-dropdown">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="user-name-display">
                            <?= htmlspecialchars($user['name']) ?> ▾
                        </span>

                        <img src="<?= $avatarPath ?>" alt="Avatar"
                             style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
                    </div>

                    <div class="user-menu">
                        <a href="/?url=profile">Tài khoản</a>
                        <a href="/?url=logout">Đăng xuất</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/?url=login">Đăng nhập</a>
                <a href="/?url=register" class="btn-register">
                    Đăng ký
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
function refreshCartCount(){
    fetch('/?url=cart/count')
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('cart-count');
            if(!el) return;

            if(data.count > 0){
                el.textContent = data.count;
                el.style.display = 'inline-block';
            } else {
                el.style.display = 'none';
            }
        });
}

refreshCartCount();
setInterval(refreshCartCount, 2000);
</script>
