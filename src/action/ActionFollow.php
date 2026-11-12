<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionFollow extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user']['idUser'])) {
            return "<p>Vous devez être connecté pour vous abonner.</p>";
        }

        if (!isset($_POST['idToFollow'])) {
            return "<p>Erreur : Identifiant de l'utilisateur à suivre manquant.</p>";
        }

        $idSuiveur = $_SESSION['user']['idUser'];
        $idSuivi   = $_POST['idToFollow'];

        if ($idSuiveur == $idSuivi) {
            header('Location: ?action=utilisateur&erreur=self_follow');
            exit();
        }

        $repo = TouiteurRepository::getInstance();
        if ($idSuivi && !$repo->isFollowing($idSuiveur, (int)$idSuivi)) {
            $repo->addFollow($idSuiveur, (int)$idSuivi);
        }

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}