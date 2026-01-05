<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h2>Thêm Category</h2>
    <form method="POST" action="?url=admin/categories/store">
        <div class="mb-3">
            <label class="form-label">Tên Category</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">➕ Thêm</button>
        <a href="?url=admin/categories" class="btn btn-secondary">Hủy</a>
    </form>
</div>
