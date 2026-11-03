<?php
namespace touiteur\repository;

use PDO;

class TouiteurRepository{
    private PDO $pdo;
    private static ?TouiteurRepository $instance = null;

    private function __construct(array $config) {
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
        
        $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance(): TouiteurRepository{
        if (is_null(self::$instance)) {
            $iniPath = __DIR__ . '/../config/sae.db.ini';
            $config = parse_ini_file($iniPath);
            self::$instance = new TouiteurRepository($config);
        }
        return self::$instance;
    }

    public function getTouitById(int $id): ?array {}

}