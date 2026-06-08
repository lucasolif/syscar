<?php

namespace App\Core;

use PDO;
use PDOException;

class Database{
    private static ?PDO $conn = null;

    public static function getConnection(): PDO{
        if (self::$conn === null) {
            $config = require __DIR__ . '/../../config/database.php';

            try {
                self::$conn = new PDO(
                    "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                    $config['user'],
                    $config['password']
                );

                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}