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

    public function getTagById(int $id) : array {
        $query = "SELECT libelle FROM tag WHERE idTag = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTouitesByTag(int $id) : array {
        $query = "SELECT T.idTouite, Touit.message, U.idUser, U.prenom
                  FROM Tag2Touite T
                  JOIN Touite Touit ON Touit.idTouite = T.idTouite
                  JOIN Users U ON U.idUser = Touit.idUser
                  WHERE T.idTag = :id
                  ORDER BY Touit.dateTouite DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Cette méthode permet de renvoyer tout les tags de la base de données
     * @return array qui est le type de contenue renvoyer par cette méthode
     */
    public function getTag() : array {
        $query = "SELECT idTag, libelle FROM Tag ORDER BY libelle";
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
        $query = "SELECT t.idTouite, t.message, u.idUser, u.prenom
                  FROM Touite t
                  JOIN Users u       ON t.idUser = u.idUser
                  JOIN Tag2Touite tt ON tt.idTouite = t.idTouite
                  WHERE tt.idTag = :id
                  ORDER BY t.dateTouite DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function addTouit(string $texte, int $idUser): int {
        $stmt = $this->pdo->prepare("INSERT INTO Touite (message, dateTouite, idUser) VALUES (:message, NOW(), :idUser)");
        $stmt->execute(['message' => $texte, 'idUser' => $idUser]);
        $idTouite = $this->pdo->lastInsertId();  

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
        $stmt = $this->pdo->prepare("SELECT idUser, prenom, email FROM Users WHERE prenom = :prenom AND email = :email");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function prenomOuEmailExiste(string $prenom, string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT idUser FROM Users WHERE prenom = :prenom OR email = :email");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function addUser(string $prenom, string $email): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO Users (prenom, email) VALUES (:prenom, :email)");
        $stmt->execute(['prenom' => $prenom, 'email' => $email]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Méthode qui permet d'obtenir tout les utilisateurs de la base de données
     * @return void
     */
    public function getUser() {
        $stmt = $this->pdo->prepare("SELECT prenom FROM User");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui permet d'avoir tout les followers d'un utilisateur
     * @param int $idUser est l'id de l'utilisateur recherché dans la base de donnée
     * @return array retourne une liste d'utilisateur
     */
    public function getFollowers(int $idUser) {
        $query = "SELECT F.idFollower FROM Follow F, user U WHERE F.idFollower = U.idUSER AND F.idFollower = :idUser";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersTriFollowers() {
        $query = "SELECT U.idUser, U.prenom, COUNT(F.idFollow) AS nb_followers 
              FROM User U 
              LEFT JOIN Follow F ON U.idUser = F.idFollow 
              GROUP BY U.idUser, U.prenom 
              ORDER BY nb_followers DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}