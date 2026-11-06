<?php
namespace touiteur\repository;

use PDO;
use touiteur\entite\User;

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
        $query = "SELECT libelle, idTag FROM Tag WHERE idTag = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTouitesByTag(int $id) : array {
        $query = "SELECT T.idTouite, Touit.message, U.prenom as auteur, U.idUser
              FROM Tag2Touite T 
              JOIN Touite Touit ON Touit.idTouite = T.idTouite 
              JOIN Users U ON U.idUser = Touit.idUser 
              WHERE T.idTag = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTagsByTouite(int $idTouite): array {
        $query = "SELECT Tag.idTag, Tag.libelle 
              FROM Tag 
              JOIN Tag2Touite ON Tag.idTag = Tag2Touite.idTag 
              WHERE Tag2Touite.idTouite = :idTouite";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idTouite' => $idTouite]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cette méthode permet de renvoyer tout les tags de la base de données
     * @return array qui est le type de contenue renvoyer par cette méthode
     */
    public function getTag() : array {
        $query = "SELECT DISTINCT libelle, idTag FROM Tag WHERE libelle IS NOT NULL";
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
        $query = "SELECT T.idTag from Tag2Touite where idTouite = :id";
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
            $stmt = $this->pdo->prepare("SELECT MAX(idTag) FROM Tag");
            $stmt->execute();
            $idTag = $stmt->fetchColumn() + 1;

            $stmt = $this->pdo->prepare("INSERT INTO Tag (idTag, libelle) VALUES (:idTag, :libelle)");
            $stmt->execute(['idTag' => $idTag, 'libelle' => $tagNom]);
            
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
    public function getUser() : array {
        $stmt = $this->pdo->prepare("SELECT prenom FROM Users");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui permet d'avoir tout les followers d'un utilisateur
     * @param int $idUser est l'id de l'utilisateur recherché dans la base de donnée
     * @return array retourne une liste d'utilisateur
     */
    public function getFollowers(int $idUser) : array{
        $query = "SELECT F.idFollower FROM Follow F, Users U WHERE F.idFollower = U.idUSER AND F.idFollower = :idUser";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersTriFollowers() : array {
        $query = "SELECT U.idUser, U.prenom, COUNT(F.idFollow) AS nb_followers 
              FROM Users U 
              LEFT JOIN Follow F ON U.idUser = F.idFollow 
              GROUP BY U.idUser, U.prenom 
              ORDER BY nb_followers DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function followtagUser(int $idUser, int $idTag) : void {
        $query = "insert into followtag (idUser, idTag) values (:idUser, :idTag)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser, 'idTag' => $idTag]);
    }

    public function getFollowedTagsByUser(int $idUser): array {
        $query = "SELECT t.idTag, t.libelle 
              FROM Tag t 
              JOIN Followtag f ON t.idTag = f.idTag 
              WHERE f.idUser = :idUser";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }























    public function getProfilPerso(int $idUser) {
        $query = "select prenom, email, idUser 
                  from Users 
                  where idUser = :idUser";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new User($row['prenom'], $row['email'], (int)$row['idUser']);
    }



    public function getInfoProfil(int $idUser) {
        $query = "select 
                    (select count(*) from Follow where idFollow = ?) as abo,
                    (select count(*) from Follow where idFollower = ?) as follower,
                    (select count(*) from Touite where idUser = ?) as touite";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idUser, $idUser, $idUser]);
        return $stmt->fetch(PDO::FETCH_NUM) ?: [0, 0, 0];
    }





    public function getTouiteByUser(int $idUser) {
        $query = "select Touite.message, Touite.dateTouite, Touite.idUser
                  from Touite
                  where Touite.idUser = :idUser
                  order by Touite.dateTouite desc";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





    public function isFollowing(int $idSuiveur, int $idSuivi): bool {
        //On compte le nombre de ligne en fonction de l'ID (c'est malin hein ?)
        $query = "select count(*) 
                  from Follow 
                  where idFollower = :idSuiveur and idFollow = :idSuivi";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSuiveur' => $idSuiveur, 'idSuivi'   => $idSuivi]);
        // Si count > 0, ça renvoie true, sinon false
        return ($stmt->fetchColumn() > 0);
    }





    public function addFollow(int $idSuiveur, int $idSuivi) {
        $query = "insert into Follow (idFollower, idFollow) values (:idSuiveur, :idSuivi)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSuiveur' => $idSuiveur, 'idSuivi' => $idSuivi]);
    }

    public function removeFollow(int $idSuiveur, int $idSuivi) {
        $query = "delete from Follow where idFollower = :idSuiveur and idFollow = :idSuivi";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['idSuiveur' => $idSuiveur, 'idSuivi' => $idSuivi]);
    }
























    public function getTouitesByUserId(int $id) : array {
        $query = "SELECT idTouite, message FROM Touite WHERE idUser = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}