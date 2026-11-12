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
        $baseId = $_POST['id'] ?? $_POST['idUser'] ?? $_POST['idFollow'] ?? $_GET['id'] ?? $_GET['idUser'] ?? 0;
        $idSuivi = (int)$baseId;

        if ($idSuivi <= 0 || $idSuiveur === $idSuivi) {
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?action=utilisateur'));
            exit();
        }

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