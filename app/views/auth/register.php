<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert-error">
        ⚠️ <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="login-wrapper">
    <link rel="stylesheet" href="/GocCaPhe/public/assets/css/login.css">

    <form class="login-card" method="post"
          action="/GocCaPhe/public/index.php?url=register-handle">

        <div class="login-header">
            <h2>☕ Góc Cà Phê</h2>
            <p>Tạo tài khoản mới</p>
        </div>

        <div class="input-group">
    <label>Họ và tên</label>
    <input type="text" name="name" placeholder="Nhập họ tên" required>
 </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
        </div>

        <div class="input-group password-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>
        <div class="input-group password-group">
    <label>Nhập lại mật khẩu</label>
    <input type="password" name="password_confirm" required>
    <span class="toggle-password" onclick="togglePassword()">👁️</span>
</div>

        <button type="submit" class="btn-login">
            Đăng ký
        </button>

        <div class="login-footer">
            <span>Đã có tài khoản?</span>
            <a href="/GocCaPhe/public/index.php?url=login">Đăng nhập</a>
        </div>

    </form>

    <script src="/GocCaPhe/public/assets/js/login.js"></script>
</div>
