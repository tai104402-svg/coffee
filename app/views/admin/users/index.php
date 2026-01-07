<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý người dùng</h2>
        <a href="?url=admin/users/create" class="btn btn-primary">
            ➕ Thêm user
        </a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <?php
                        switch($u['role']) {
                            case 'ADMIN': echo '<span class="badge bg-danger">ADMIN</span>'; break;
                            case 'STAFF': echo '<span class="badge bg-warning text-dark">STAFF</span>'; break;
                            default: echo '<span class="badge bg-secondary">USER</span>';
                        }
                    ?>
                </td>
                <td class="text-center">
                    <a href="?url=admin/users/edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-success me-1">
                        ✏️ Sửa
                    </a>
                    <a href="?url=admin/users/delete&id=<?= $u['id'] ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Bạn có chắc muốn xóa user này?')">
                        🗑️ Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
