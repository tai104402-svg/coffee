<?php
class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                $host = getenv('DB_HOST') ?: 'sql3.freesqldatabase.com';
                $db   = getenv('DB_NAME') ?: 'sql3813594';
                $user = getenv('DB_USER') ?: 'sql3813594';
                $pass = getenv('DB_PASS') ?: 'ViQuMb6UAA';
                $port = getenv('DB_PORT') ?: 3306;
                $charset = 'utf8mb4';

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                ];

                self::$conn = new PDO($dsn, $user, $pass, $options);

            } catch (PDOException $e) {
                die('❌ Lỗi kết nối CSDL: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
