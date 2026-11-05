<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class DisplayTag extends Action {

    public function execute(): string {

        $repo = TouiteurRepository::getInstance();
        $tag = $repo->getTag();

        if (empty($tag)) {
            return "<p>Erreur : Tag introuvable.</p>";
        }

        $html  = "";
        $html .= "<div class='main-container'>";
        $html .= "<h2>Liste de tous les tags et leurs touites</h2>";

        foreach ($tag as $tags) {
            $idTag = (int) ($tags['idTag'] ?? 0);
            $libelleTag = filter_var($tags['libelle'] ?? 'Inconnu', FILTER_SANITIZE_SPECIAL_CHARS);

            $touitesDuTag = $repo->getTouitesByTag($idTag);

            $html .= "<div class='tag-container'>";
            $html .= "<h2>Touites associés au tag #{$libelleTag}</h2>";
            if (empty($touitesDuTag)) {
                $html .= "<p>Aucun touite associé à ce tag.</p>";
            } else {
                foreach ($touitesDuTag as $touite) {
                    $message = filter_var($touite['message'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    $auteur = filter_var($touite["auteur"] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    $idUser = (int) ($touite['idUser'] ?? 0);
                    $idTouite = (int) ($touite['idTouite'] ?? 0);

                    $html .= "<div class=\"touite\">";
                    $html .= "<p><a href=\"?action=utilisateur&id={$idUser}\">{$auteur}</a></p>";
                    $html .= "<p><a href=\"?action=display-touite&id={$idTouite}\">{$message}</a></p>";
                    $html .= "</div>";
                }
            }
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