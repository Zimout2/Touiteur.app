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

        $idSuiveur = (int) $_SESSION['user']['idUser'];
        $idSuivi   = (int) $_POST['idToFollow'];

        if ($idSuiveur === $idSuivi) {
            return "<p>Vous ne pouvez pas vous abonner à vous-même.</p>";
        }

        $repo = TouiteurRepository::getInstance();
        $repo->addFollow($idSuiveur, $idSuivi);

        header("Location: index.php?action=profil&id={$idSuivi}");
        exit();
    }
}