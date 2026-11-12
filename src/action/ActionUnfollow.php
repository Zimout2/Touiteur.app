<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionUnfollow extends Action {

    public function execute(): string {

        if (!isset($_SESSION['user']['idUser'])) {
            header('Location: ?action=connexion');
            exit();
        }

        $idSuiveur = (int)$_SESSION['user']['idUser'];
        $idSuivi = (int)($_POST['idToUnfollow'] ?? 0);

        if ($idSuivi <= 0 || $idSuiveur === $idSuivi) {
            header('Location: ?action=utilisateur');
            exit();
        }

        $repo = TouiteurRepository::getInstance();
        $repo->removeFollow($idSuiveur, $idSuivi);

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}
