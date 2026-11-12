<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class ActionFollow extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?action=connexion');
            exit();
        }

        if (!isset($_POST['idToFollow'])) {
            return "<p>Erreur : Identifiant de l'utilisateur à suivre manquant.</p>";
        }

        $idSuiveur = (int)$_SESSION['user_id'];
        $idSuivi = (int)($_POST['id'] ?? $_GET['id'] ?? 0);

        if ($idSuivi === 0 || $idSuiveur === $idSuivi) {
            header('Location: ?action=displayUser&id=' . $idSuivi);
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