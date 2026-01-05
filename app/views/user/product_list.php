<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <h1>Danh sách sản phẩm</h1>

    <!-- Lọc theo danh mục -->
    <form method="get" action="/GocCaPhe/public/index.php">
        <input type="hidden" name="url" value="menu">
        <select name="category_id" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == ($category_id ?? '')) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="product-list">
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <div class="product-image">
                <img src="/GocCaPhe/public/assets/img/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            </div>

            <div class="product-info">
                <h3><?= htmlspecialchars($p['name']) ?></h3>
                <p class="category">Danh mục: <?= htmlspecialchars($p['category_name']) ?></p>

                <p class="status <?= $p['status'] == 'AVAILABLE' ? 'available' : 'hidden' ?>">
                    <?= $p['status'] == 'AVAILABLE' ? '✔ Còn hàng' : '✖ Hết hàng' ?>
                </p>

                <div class="price-btn-wrapper">
                    <p class="price"><?= number_format($p['price'], 0, ',', '.') ?>₫</p>
                    <form class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button type="submit" <?= $p['status'] == 'HIDDEN' ? 'disabled' : '' ?>>Thêm vào giỏ</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(form);

        const res = await fetch('/GocCaPhe/public/index.php?url=cart/add', {
            method: 'POST',
            body: formData
        });

        if(res.ok){
            const data = await res.json();

            if(data.success){
                // toast
                const toast = document.createElement('div');
                toast.className = 'cart-toast';
                toast.textContent = '✅ Thêm vào giỏ hàng thành công';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);

                // update số lượng giỏ hàng
                const cartSpan = document.querySelector('.btn-cart .cart-count');
                if(cartSpan){
                    cartSpan.textContent = data.cartCount;
                } else {
                    const span = document.createElement('span');
                    span.className = 'cart-count';
                    span.textContent = data.cartCount;
                    document.querySelector('.btn-cart').appendChild(span);
                }
            }
        }
    });
});

</script>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
