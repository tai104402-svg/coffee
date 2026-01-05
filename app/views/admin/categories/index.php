<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Categories</h2>
        <a href="?url=admin/categories/create" class="btn btn-primary">
            ➕ Thêm Category
        </a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên Category</th>
                <th>Mô tả</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td><?= htmlspecialchars($cat['description']) ?></td>
                <td class="text-center">
                    <a href="?url=admin/categories/edit&id=<?= $cat['id'] ?>" class="btn btn-sm btn-success me-1">
                        ✏️ Sửa
                    </a>
                    <a href="?url=admin/categories/delete&id=<?= $cat['id'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Bạn có chắc muốn xóa category này?')">
                        🗑️ Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
