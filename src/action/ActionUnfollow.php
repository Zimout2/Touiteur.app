<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionUnfollow extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user']['idUser']) || !isset($_POST['idToUnfollow'])) {
            return "<p>Requête invalide.</p>";
        }

        $idSuiveur = (int) $_SESSION['user']['idUser'];
        $idSuivi   = (int) $_POST['idToUnfollow'];

        $repo = TouiteurRepository::getInstance();
        $repo->removeFollow($idSuiveur, $idSuivi);

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}