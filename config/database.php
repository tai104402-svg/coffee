<?php
class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                $host = 'sql3.freesqldatabase.com';
                $db   = 'sql3813594';
                $user = 'sql3813594';
                $pass = 'ViQuMb6UAA';
                $port = 3306;
                $charset = 'utf8mb4';

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$conn = new PDO($dsn, $user, $pass, $options);

            } catch (PDOException $e) {
                die('❌ Lỗi kết nối CSDL: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
