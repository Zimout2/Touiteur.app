<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionUnfollow extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user']['idUser']) || !isset($_POST['idToUnfollow'])) {
            return "<p>Requête invalide.</p>";
        }

        $idSuiveur = $_SESSION['user']['idUser'];
        $idSuivi   = $_POST['idToUnfollow'];

        $repo = TouiteurRepository::getInstance();
        $repo->removeFollow($idSuiveur, $idSuivi);

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}