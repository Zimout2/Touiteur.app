<?php
namespace touiteur\repository;

use PDO;

class TouiteurRepository{
    private PDO $pdo;
    private static ?TouiteurRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf) {
        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $conf['username'], $conf['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ]);
    }

    public static function setConfig(string $file): void {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Erreur de lecture du fichier de configuration : $file");
        }
        self::$config = $conf;
    }

    public static function getInstance(): TouiteurRepository{

        if (self::$instance === null) {
            if (empty(self::$config)) {
                throw new \Exception("Configuration BD non définie (appeler setConfig)");
            }
            self::$instance = new TouiteurRepository(self::$config);
        }
        return self::$instance;
    }

    public function getTouitById(int $id): ?array {
        $query = "SELECT t.id_touite AS id, 
                     t.message AS texte, 
                     t.date AS date_publication, 
                     t.likes AS score, 
                     u.prenom AS auteur 
              FROM Touite t 
              JOIN User u ON t.id_user = u.id_user 
              WHERE t.id_touite = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();
        return $result ?: null;
    }

    Public function addTouit(string $texte, int $idUser): int {
        $query = "INSERT INTO Touite (message, date, likes, id_user) VALUES (:message, NOW(), 0, :id_user)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['message' => $texte, 'id_user' => $idUser]);
        return (int)$this->pdo->lastInsertId();
    }
    
    public function addTagToTouit(int $idTouit , string $tagNom):void {
        $stmt = $this->pdo->prepare("Select id_tag from Touite where id_touite =:id_touite");
        $stmt ->execute(['id_touite' => $idTouit]);
        $row = $stmt->fetch();
        $tagArray = ($row && !empty($row['id_tag'])) ? json_decode($row['id_tag'], true) : [];

        if (!in_array($tagNom, $tagArray)) {
            $tagArray[] = $tagNom;
        }
        $stmtUpdate = $this->pdo->prepare("UPDATE Touite SET id_tag = :id_tag WHERE id_touite = :id_touite");
        $stmtUpdate ->execute(['tags' => json_encode($tagArray), 'id_touite' => $idTouit]);
    }

}