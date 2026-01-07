<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Reservation
{
    private static function db()
    {
        return Database::connect();
    }

    private static function excelPath()
    {
        return dirname(__DIR__, 2) . '/storage/reservations.xlsx';
    }

    /* ================= CREATE ================= */
    public static function create($data)
    {
        $conn = self::db();

        $sql = "INSERT INTO reservations
                (user_id, hoten, phone, songuoi, ngay, gio, ghichu, trangthai)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'CHO_DUYET')";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $data['user_id'],
            $data['hoten'],
            $data['phone'],
            $data['songuoi'],
            $data['ngay'],
            $data['gio'],
            $data['ghichu']
        ]);

        $id = $conn->lastInsertId();
        self::appendExcel($id, $data, 'CHO_DUYET');
    }

    /* ================= GET BY USER ================= */
    public static function getByUser($userId)
    {
        $stmt = self::db()->prepare(
            "SELECT * FROM reservations WHERE user_id = ? ORDER BY id DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================= READ ================= */
    public static function all()
    {
        $sql = "SELECT r.*, u.name AS staff_name, u.role AS staff_role
                FROM reservations r
                LEFT JOIN users u ON r.approved_by = u.id
                ORDER BY r.id DESC";

        return self::db()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================= APPROVE ================= */
    public static function approve($id, $staffId)
    {
        $sql = "UPDATE reservations
                SET trangthai='DA_DUYET',
                    approved_by=?,
                    approved_at=NOW()
                WHERE id=?";

        self::db()->prepare($sql)->execute([$staffId, $id]);
        self::updateExcelStatus($id, 'DA_DUYET');
    }

    /* ================= CANCEL ================= */
    public static function cancel($id, $staffId)
    {
        $sql = "UPDATE reservations
                SET trangthai='HUY',
                    approved_by=?,
                    approved_at=NOW()
                WHERE id=?";

        self::db()->prepare($sql)->execute([$staffId, $id]);
        self::updateExcelStatus($id, 'HUY');
    }

    /* ================= EXCEL ================= */
    private static function appendExcel($id, $data, $status)
    {
        $path = self::excelPath();

        if (file_exists($path) && filesize($path) > 0) {
            try {
                $spreadsheet = IOFactory::load($path);
            } catch (Exception $e) {
                $spreadsheet = self::createNewSpreadsheet();
            }
        } else {
            $spreadsheet = self::createNewSpreadsheet();
        }

        $sheet = $spreadsheet->getActiveSheet();
        $row = $sheet->getHighestRow() + 1;

        $sheet->fromArray([
            $id,
            $data['hoten'],
            $data['phone'],
            $data['songuoi'],
            $data['ngay'],
            $data['gio'],
            $data['ghichu'],
            $status
        ], null, "A{$row}");

        (new Xlsx($spreadsheet))->save($path);
    }

    private static function updateExcelStatus($id, $status)
    {
        $path = self::excelPath();
        if (!file_exists($path) || filesize($path) === 0) return;

        try {
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->getRowIterator(2) as $row) {
                $i = $row->getRowIndex();
                if ($sheet->getCell("A{$i}")->getValue() == $id) {
                    $sheet->setCellValue("H{$i}", $status);
                    break;
                }
            }

            (new Xlsx($spreadsheet))->save($path);
        } catch (Exception $e) {
            // error_log($e->getMessage());
        }
    }

    private static function createNewSpreadsheet()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray([
            ['ID', 'Họ tên', 'Phone', 'Số người', 'Ngày', 'Giờ', 'Ghi chú', 'Trạng thái']
        ]);
        return $spreadsheet;
    }
}
