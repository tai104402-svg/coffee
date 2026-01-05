<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h2>Sửa User</h2>

    <form method="POST" action="?url=admin/users/update">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label>Tên</label>
            <input name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="USER" <?= $user['role']=='USER'?'selected':'' ?>>USER</option>
                <option value="STAFF" <?= $user['role']=='STAFF'?'selected':'' ?>>STAFF</option>
                <option value="ADMIN" <?= $user['role']=='ADMIN'?'selected':'' ?>>ADMIN</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Mật khẩu mới (nếu đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="?url=admin/users" class="btn btn-secondary">Hủy</a>
    </form>
</div>
