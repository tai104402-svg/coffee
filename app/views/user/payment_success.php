<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 text-center">
    <h2>✅ Thanh toán thành công!</h2>
    <p>Đơn hàng của bạn đang trên đường giao đến bạn</p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($_SESSION['last_order']['address']) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($_SESSION['last_order']['phone']) ?></p>
    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($_SESSION['last_order']['method']) ?></p>

    <a href="/GocCaPhe/public/index.php?url=cart" class="btn btn-primary mt-3">Quay lại giỏ hàng</a>
</div>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>