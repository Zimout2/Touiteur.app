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
        $query = "SELECT Ta.id_tag AS id, Ta.id_tuites, Ta.libellle AS texte FROM tag Ta, touite To WHERE Ta.id_touites = To.id_touites AND Ta.id_touite = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: [];
    }

    /**
     * Cette méthode permet de renvoyer tout les tags de la base de données
     * @return array qui est le type de contenue renvoyer par cette méthode
     */
    public function getTag() : array {
        $query = "SELECT DISTINCT libelle FROM tag WHERE libelle IS NOT NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cette méthode permet de trouver un touite par son id de tag
     * @param int $id est l'id du touite
     * @return array est le type de contenue retourner
     */
    public function getTouiteByTagId(int $id) : array {
        $query = "SELECT T.idTag from tag2touite where idTouite = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idTouite' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
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
        $query = "SELECT t.idTouite, t.message, t.dateTouite, u.idUser, u.prenom
                  FROM Touite t
                  JOIN users u ON t.idTouite = u.idUser
                  ORDER BY t.dateTouite DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserByPrenomEmail(string $prenom, string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT id_user, prenom, email FROM User WHERE prenom = :prenom AND email = :email");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function prenomOuEmailExiste(string $prenom, string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT id_user FROM User WHERE prenom = :prenom OR email = :email");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function addUser(string $prenom, string $email): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO User (prenom, email) VALUES (:prenom, :email)");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        return $this->pdo->lastInsertId();
    }

}