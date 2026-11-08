<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionFollowTag extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user']['idUser'])) {
            return "<p>Vous devez être connecté pour vous abonner.</p>";
        }

        if (!isset($_POST['idTagToFollow'])) {
            return "<p>Erreur : Identifiant de l'utilisateur à suivre manquant.</p>";
        }

        $idUser = $_SESSION['user']['idUser'];
        $idTag   = $_POST['idTagToFollow'];
        
        $repo = TouiteurRepository::getInstance();
        $repo->addFollowTag($idUser, $idTag);

        header("Location: index.php?action=profil-tag&id={$idTag}");
        exit();
    }
}