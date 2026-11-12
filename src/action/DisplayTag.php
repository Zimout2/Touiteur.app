<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class DisplayTag extends Action {

    /**
     * Méthode qui permet d'affichage la liste des tags suivie par le user
     * @return string renvoie la page html correspondant à la description de la méthode
     * @throws \Exception
     */
    public function execute(): string {

        // Récupérations de tout les méthode issue du repo
        $repo = TouiteurRepository::getInstance();
        $tag = $repo->getTag();

        if (empty($tag)) {
            return "<p>Erreur : Tag introuvable.</p>";
        }
      
        $html  = "";
            $html .= "<div class='tag-container'>";
            $html .= "<h2>Listes des tags :</h2>";
            foreach ($tag as $tags) {
                // Récupération de l'id du tag
                $idTag = (int) ($tags['idTag'] ?? 0);

                // Filtrage du libelle id de l'url pour inviter les injections
                $libelleTag = filter_var($tags['libelle'] ?? 'Inconnu', FILTER_SANITIZE_SPECIAL_CHARS);

                $touitesDuTag = $repo->getTouitesByTag($idTag);

                if (empty($touitesDuTag)) {
                    $html .= "<p>Aucun touite associé à ce tag.</p>";
                } else {
                    // Lien cliquable permettant de conduire à l'ensemble des touites gravitant autour de ce fameux tag
                    $html .= "<div class='liste_tag'>";
                    $html .= "<p> - <a href=\"?action=profil-tag&id={$idTag}\">#{$libelleTag}</a></p>";
                    $html .= "<p></p>";
                }
            }
            $html .= "</div>";

        // Affichage html
        return <<<HTML
        <style>
            .tag-container {
                max-width: 600px;
                margin: 0 auto;
                text-align: center;
                font-family: Arial, sans-serif;
            }
            .liste_tag {
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