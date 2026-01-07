<?php require_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h2>Thêm User</h2>
    <form method="POST" action="?url=admin/users/store">
        <div class="mb-3">
            <label>Tên</label>
            <input name="name" class="form-control" required>   
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="USER">USER</option>
                <option value="STAFF">STAFF</option>
                <option value="ADMIN">ADMIN</option>
            </select>
        </div>

        <button class="btn btn-primary">Thêm</button>
        <a href="?url=admin/users" class="btn btn-secondary">Hủy</a>
    </form>
</div>
