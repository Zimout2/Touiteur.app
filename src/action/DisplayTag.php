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

        $html .= "<div class='tag-container'>";
        $html .= "<h2>Listes des tags :</h2>";
        foreach ($tag as $tags) {
            $idTag = (int) ($tags['idTag'] ?? 0);
            $libelleTag = filter_var($tags['libelle'] ?? 'Inconnu', FILTER_SANITIZE_SPECIAL_CHARS);

            $touitesDuTag = $repo->getTouitesByTag($idTag);

            if (empty($touitesDuTag)) {
                $html .= "<p>Aucun touite associé à ce tag.</p>";
            } else {
                $html .= "<p><a href=\"?action=profil-tag&id={$idTag}\">#{$libelleTag}</a></p>";                $html .= "<p></p>";
            }
        }
        $html .= "</div>";

        return <<<HTML
        <style>
            .tag-container {
                max-width: 600px;
                margin: 0 auto;
                text-align: center;
                font-family: Arial, sans-serif;
            }
        </style>

        <div class='tag-container'>
            {$html}
        </div>
        HTML;
    }
}