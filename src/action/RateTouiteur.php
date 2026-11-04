<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository; 


class RateTouiteur extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user'])) {
            return "<p>Vous devez être connecté pour évaluer un touite <a href=\"?action=login\">Se connecter</a></p>";
        }
        $userId =$_SESSION['user'];

        $idTouit = filter_var($_GET['id'] ?? $_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $valeur  = filter_var($_GET['val'] ?? $_POST['val'] ?? null, FILTER_VALIDATE_INT);

        if (!$idTouit || !in_array($valeur, [1, -1])) {
            return "<p>Requête d'évaluation invalide.</p>";
        }
        $repo = TouiteurRepository::getInstance();

        //TODO

    }




}