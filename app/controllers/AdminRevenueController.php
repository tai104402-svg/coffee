<?php
require_once __DIR__ . '/../models/RevenueModel.php';

class AdminRevenueController {
    private $revenueModel;

    public function __construct() {
        $this->revenueModel = new RevenueModel();
    }

    public function index() {
<<<<<<< HEAD
        $filterDate = $_GET['date'] ?? date('Y-m-d');
        $filterMonth = $_GET['month'] ?? date('m');
        $filterYear = $_GET['year'] ?? date('Y');

        // --- XỬ LÝ LƯU CHI PHÍ ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_expenses') {
            $staff = (int)str_replace(['.', ','], '', $_POST['staff_cost']);
            $electric = (int)str_replace(['.', ','], '', $_POST['electric_cost']);
            $materials = (int)str_replace(['.', ','], '', $_POST['material_cost']);
            
            $this->revenueModel->saveMonthlyExpenses($filterMonth, $filterYear, $staff, $electric, $materials);
            header("Location: index.php?url=admin/revenues&month=$filterMonth&year=$filterYear");
            exit;
        }

        // 1. Số liệu ngày
        $dailyStats = $this->revenueModel->getDailyStats($filterDate);

        // 2. Số liệu tháng & Chi phí
        $monthlyRevenueRaw = $this->revenueModel->getMonthlyStats($filterMonth, $filterYear);
        $monthlyRevenue = $monthlyRevenueRaw['revenue'];
        
        // Lấy chi phí từ bảng monthly_expenses
        $expenses = $this->revenueModel->getMonthlyExpenses($filterMonth, $filterYear);
        
        // Tính tổng chi và lợi nhuận
        $totalExpenses = $expenses['staff_cost'] + $expenses['electricity_water_cost'] + $expenses['materials_cost'];
        $realProfit = $monthlyRevenue - $totalExpenses;

        // 3. Biểu đồ
        $chartData = $this->revenueModel->getRevenueByCategory($filterMonth, $filterYear);
        $chartLabels = []; $chartValues = [];
=======
        // 1. Lấy tham số filter (Fix lỗi lọc)
        $filterDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $filterMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
        $filterYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

        // 2. Lấy số liệu thống kê
        $dailyStats = $this->revenueModel->getDailyStats($filterDate);
        $dailySalary = $this->revenueModel->getDailyStaffCost($filterDate);
        $dailyProfit = $dailyStats['total_revenue'] - $dailySalary;

        $monthlyStats = $this->revenueModel->getMonthlyStats($filterMonth, $filterYear);
        $monthlyProfit = $monthlyStats['revenue'] - $monthlyStats['salary'];

        // 3. [MỚI] Lấy dữ liệu biểu đồ
        $chartData = $this->revenueModel->getRevenueByCategory($filterMonth, $filterYear);

        // Chuẩn bị dữ liệu cho Chart.js (Chuyển sang JSON)
        $chartLabels = [];
        $chartValues = [];
>>>>>>> dcea8e81e23200a1ef932b7761314d51206950ef
        foreach ($chartData as $item) {
            $chartLabels[] = $item['name'];
            $chartValues[] = $item['total_money'];
        }

        require __DIR__ . '/../views/admin/revenue/index.php';
    }
<<<<<<< HEAD

    public function export() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $month = $_GET['month'] ?? date('m');
        $year  = $_GET['year'] ?? date('Y');
        $exportName = $_SESSION['user']['name'] ?? 'Admin';
        $this->revenueModel->exportRevenueExcel($month, $year, $exportName);
    }
=======
>>>>>>> dcea8e81e23200a1ef932b7761314d51206950ef
}