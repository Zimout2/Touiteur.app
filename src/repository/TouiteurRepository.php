<?php
namespace touiteur\repository;

use PDO;

class TouiteurRepository{
    private PDO $pdo;
    private static ?TouiteurRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf) {
        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']}";
        $this->pdo = new PDO($dsn, $conf['username'], $conf['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ]);
        $this->pdo->prepare('SET NAMES \'UTF8\'')->execute();
    }

    public static function setConfig(string $file): void {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Erreur de lecture du fichier de configuration : $file");
        }
        self::$config = $conf;
    }

    public static function getInstance(): TouiteurRepository{

        if (is_null(self::$instance)) {
            if (count(self::$config) === 0) {
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

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getTagById(int $id) : array {
        $query = "SELECT T.id_tag AS id, T.id_tuites, T.libellle AS texte FROM tag T WHERE T.id_tag = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]); // Utilisation de 'id' pour correspondre à :id
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: [];
    }

    public function addTouit(string $texte, int $idUser): int {
        $query = "INSERT INTO Touite (message, date, likes, id_user) VALUES (:message, NOW(), 0, :id_user)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['message' => $texte, 'id_user' => $idUser]);
        return $this->pdo->lastInsertId();
    }
    
    public function addTagToTouit(int $idTouit , string $tagNom):void {
        $query = "INSERT INTO Tag (libellle, id_tuites) VALUES (:libelle, :id_touite)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelle' => $tagNom, 'id_touite' => $idTouit]);
    }
    public function getTouites(): array{
        $query = "SELECT t.id_touite, t.message, t.date, u.id_user, u.prenom
                  FROM Touite t
                  JOIN User u ON t.id_user = u.id_user
                  ORDER BY t.date DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}