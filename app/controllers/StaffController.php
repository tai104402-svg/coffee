<?php
require_once __DIR__ . '/../models/StaffModel.php';

class StaffController {
    private $staffModel;

    public function __construct() {
        $this->staffModel = new StaffModel();
    }

    // Dashboard chính của nhân viên
    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'STAFF') {
            header('Location: /GocCaPhe/public/index.php?url=login');
            exit;
        }

        $user = $_SESSION['user'];
        // Lấy lịch cá nhân
        $mySchedules = $this->staffModel->getMySchedule($user['id']);

        require __DIR__ . '/../views/staff/dashboard.php';
    }
}