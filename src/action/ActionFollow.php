<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionFollow extends Action {

    public function execute(): string {

        if (!isset($_SESSION['user']['idUser'])) {
            header('Location: ?action=connexion');
            exit();
        }

        $idSuivi = (int)($_POST['idToFollow'] ?? 0);
        $idSuiveur = (int)$_SESSION['user']['idUser'];

        if ($idSuivi <= 0 || $idSuiveur === $idSuivi) {
            header('Location: ?action=utilisateur');
            exit();
        }

        $repo = TouiteurRepository::getInstance();
        if (!$repo->isFollowing($idSuiveur, $idSuivi)) {
            $repo->addFollow($idSuiveur, $idSuivi);
        }

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}