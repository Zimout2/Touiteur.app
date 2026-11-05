<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class DisplayUtilisateur extends Action {


    public function execute(): string {
        $repo = TouiteurRepository::getInstance();
        $user_list = $repo->getUsersTriFollowers();
        if (empty($user_list)) {
            return "<p>Erreur : Utilisateur introuvable.</p>";
        }
        $html  = "";
        $html .= "<div class='main-container'>";
        $html .= "<h2>Liste de tous les Utilisateurs</h2>";
        foreach ($user_list as $users) {
            $prenom = filter_var($users["prenom"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $nb_followers = $users['nb_followers'] ?? 0;
            $html .= "<div class='touite-tag'>";
            $html .= "<p>$prenom - Follower : $nb_followers</p>";
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