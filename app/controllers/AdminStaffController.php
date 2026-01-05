<?php
require_once __DIR__ . '/../models/StaffModel.php';

class AdminStaffController {
    private $staffModel;

    public function __construct() {
        $this->staffModel = new StaffModel();
    }

    // 1. Hiển thị danh sách nhân viên & Lịch làm hôm nay
    public function index() {
        $selectedDate = $_GET['date'] ?? date('Y-m-d');
        
        $staffs = $this->staffModel->getAllStaff();
        $dailyRoster = $this->staffModel->getDailyRoster($selectedDate);

        require __DIR__ . '/../views/staff/index.php';
    }

    // 2. Xử lý thêm lịch (Assign Shift)
    public function storeSchedule() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $work_date = $_POST['work_date'];
            $shift_code = $_POST['shift_code']; // 1, 2, 3

            // Định nghĩa cứng các ca làm việc
            $shifts = [
                '1' => ['name' => 'Ca Sáng',  'start' => '07:00', 'end' => '12:00'],
                '2' => ['name' => 'Ca Chiều', 'start' => '12:00', 'end' => '17:00'],
                '3' => ['name' => 'Ca Tối',   'start' => '17:00', 'end' => '22:00'],
            ];

            if (isset($shifts[$shift_code])) {
                $shift = $shifts[$shift_code];
                $this->staffModel->assignShift($user_id, $work_date, $shift['name'], $shift['start'], $shift['end']);
            }
            
            header("Location: /GocCaPhe/public/index.php?url=admin/staff&date=$work_date");
        }
    }

    // 3. Xóa lịch
    public function deleteSchedule() {
        $id = $_GET['id'];
        $this->staffModel->deleteShift($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}