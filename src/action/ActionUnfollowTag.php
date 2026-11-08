<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionUnfollowTag extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user']['idUser']) || !isset($_POST['idTagToUnfollow'])) {
            return "<p>Requête invalide.</p>";
        }

        $idUser = $_SESSION['user']['idUser'];
        $idTag   = $_POST['idTagToUnfollow'];
        
        $repo = TouiteurRepository::getInstance();
        $repo->removeFollowTag($idUser, $idTag);

        header("Location: index.php?action=profil-tag&id={$idTag}");
        exit();
    }
}