<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h2>Sửa Category</h2>
    <form method="POST" action="?url=admin/categories/update">
        <input type="hidden" name="id" value="<?= $category['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Tên Category</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($category['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">💾 Lưu</button>
        <a href="?url=admin/categories" class="btn btn-secondary">Hủy</a>
    </form>
</div>
