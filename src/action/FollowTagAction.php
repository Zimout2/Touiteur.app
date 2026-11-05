<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class FollowTagAction extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user'])) {
            return "<p>Vous devez être connecté pour suivre un tag. <a href=\"?action=connexion\">Se connecter</a></p>";
        }

        $idUser = (int) $_SESSION['user']['idUser'];
        $repo = TouiteurRepository::getInstance();

        // Si on arrive en POST, on tente d'enregistrer le tag
        if ($this->http_method === 'POST' || !empty($_POST['idTag'])) {
            $idTag = isset($_POST['idTag']) ? filter_var($_POST['idTag'], FILTER_VALIDATE_INT) : null;

            if ($idTag) {
                try {
                    $repo->followtagUser($idUser, $idTag);
                } catch (\Exception $e) {
                    $e->getMessage();
                }
            }
        }
        $tagsSuivis = $repo->getFollowedTagsByUser($idUser);

        $html  = "";
        $html .= "<div class='main-container'>";
        $html .= "<h2>Les tags que vous suivez :</h2>";

        if (empty($tagsSuivis)) {
            $html .= "<p>Vous ne suivez aucun tag pour le moment.</p>";
        } else {
            $html .= "<ul>";
            foreach ($tagsSuivis as $tag) {
                $tId = (int) ($tag['idTag'] ?? 0);
                $libelle = filter_var($tag['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $html .= "<li><a href=\"?action=displayTag&id={$tId}\">#{$libelle}</a></li>";
            }
            $html .= "</ul>";
        }

        $html .= "</div>";

        return <<<HTML
    <style>
        .tag-container {
            max-width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }
    </style>
    <div class='tag-container'>
        {$html}
    </div>
    HTML;
    }
}