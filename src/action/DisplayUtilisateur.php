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
        $html .= "<div class='main-containe'>";
        $html .= "<h2>Liste de tous les Utilisateurs</h2>";

        foreach ($user_list as $users) {
            $prenom = filter_var($users["prenom"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $id = filter_var($users['idUser'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            $html .= "<div class='touite-ta'>";
            $html .= "<p class='align-center'><strong>$prenom</strong></p>"; // LIEN VERS PROFIL
            $html .= "</div>";
        }
        $html .= "</div>";
        return <<<HTML
        <style>
            .tag-container {
                max-width: 600px;
                margin: 0 auto;
                font-family: Arial, sans-serif;
                text-align: center;
            }
            .align-left {
                text-align: left;
            }
            .align-right {
                text-align: right;
            }
        </style>

        <div class='tag-container'>
            {$html} <!-- Attention à ne pas réinjecter $html dans lui-même, adaptez selon votre variable finale -->
        </div>
        HTML;
    }
}