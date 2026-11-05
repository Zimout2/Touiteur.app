<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class DisplayUtilisateur extends Action {


    public function execute(): string {
        $repo = TouiteurRepository::getInstance();
        $user = $repo->getUser();
        if (empty($user)) {
            return "<p>Erreur : Utilisateur introuvable.</p>";
        }
        $html  = "";
        $html .= "<div class='main-container'>";
        $html .= "<h2>Liste de tous les Utilisateurs</h2>";
        foreach ($user as $users) {
            $nbfollower = filter_var($users["nbfollower"], FILTER_SANITIZE_NUMBER_INT);
            $nbsuivie = $repo->getFollowers($users["idUser"]);
            $html .= "<div class='touite-tag'>";
            $html .= "<p>Nombre de followers : $nbfollower</p>";
            $html .= "<p>Nombre de suivies : $nbsuivie</p>";
            $html .= "</div>";
        }
        $html .= "</div>";
        return <<<HTML
        <style>
            .tag-container {
                max-width: 600px;
                margin: 0 auto; /* Centre le conteneur principal sur la page */
                text-align: center; /* Centre le texte à l'intérieur */
                font-family: Arial, sans-serif;
            }
        </style>

        <div class='tag-container'>
            {$html} <!-- Attention à ne pas réinjecter $html dans lui-même, adaptez selon votre variable finale -->
        </div>
        HTML;
    }
}