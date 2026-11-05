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
            $nb_followers = $users['nb_followers'] ?? 0;
            $touite = $repo->getTouitesByUserId($id);

            $html .= "<div class='touite-ta'>";
            $html .= "<p class='align-center'>Voici l'utilisateur : <strong>$prenom</strong>. Actuellement à: <strong>$nb_followers</strong></strong> followers</p>";
            $html .= "<p class='align-center'>Voici tous les touites qu'il a réalisé :</p>";
            foreach ($touite as $t) {
                $message = filter_var($t['message'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $idTouite = (int) ($t['idTouite'] ?? 0);

                $html .= "<div class=\"touite aligne-center\">";
                $html .= "<p><a href=\"?action=display-touite&id={$idTouite}\">{$message}</a></p>";
                $html .= "</div>";
            }
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