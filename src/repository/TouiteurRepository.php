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

    public function getTag() : array {
        $query = "SELECT DISTINCT libelle FROM tag WHERE libelle IS NOT NULL";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTouiteByTagId(int $id) : array {
        $query = "SELECT T.idTag from tag2touite where idTouite = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idTouite' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function addTouit(string $texte, int $idUser): int {
        
        $stmt = $this->pdo->prepare("SELECT MAX(idTouite) FROM Touite");
        $stmt->execute();
        $idTouite = $stmt->fetchColumn() + 1;

        $query = "INSERT INTO Touite (idTouite, message, dateTouite, likeTouite, idUser) VALUES (:idTouite, :message, NOW(), 0, :idUser)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idTouite' => $idTouite, 'message' => $texte, 'idUser' => $idUser]);
        $stmt = $this->pdo->prepare("UPDATE Users SET nbTouite = nbTouite + 1 WHERE idUser = :idUser");
        $stmt->execute(['idUser' => $idUser]);
        return $idTouite;
    }
    public function addTagToTouit(int $idTouit , string $tagNom):void {
        //on regarde si le tag existe deja 
        $stmt = "SELECT idTag FROM Tag WHERE libelle = :libelle";
        $stmt = $this->pdo->prepare($stmt);
        $stmt->execute(['libelle' => $tagNom ]);
        $row  = $stmt ->fetch(PDO::FETCH_ASSOC);

        if($row){
            $idTag = $row['idTag'];
        }else{
            //sinon on le crée
            $stmt = $this->pdo->prepare("INSERT INTO Tag (libelle) VALUES (:libelle)");
            $stmt->execute(['libelle' => $tagNom]);
            $idTag = $this->pdo->lastInsertId();
        }
        //on le relie au tuite
        $stmt = $this ->pdo->prepare("INSERT INTO Tag2Touite (idTag, idTouite) VALUES (:idTag, :idTouite)");
        $stmt->execute(['idTag' => $idTag, 'idTouite' => $idTouit]);
    }
    public function getTouites(): array{
        $query = "SELECT t.idTouite, t.message, t.dateTouite, u.idUser, u.prenom
                  FROM Touite t
                  JOIN Users u ON t.idUser = u.idUser
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