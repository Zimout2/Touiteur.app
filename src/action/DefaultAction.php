<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;


class DefaultAction extends Action
{
    public function execute(): string {
        // Récuppération des méthodes issue du repo
        $obj = TouiteurRepository::getInstance();

        $touites = $obj->getTouites();

        if (count($touites) === 0) {
            return "<p>Aucun touite pour le moment.</p>";
        }
        $html = "<h2>Derniers touites</h2>";
        foreach ($touites as $t) {
            $idTouite = (int) ($t['idTouite'] ?? 0);

            
            $message = $this->retirerTags($t['message']);

            $prenom = $t['prenom'];
            $idUser = (int) ($t['idUser'] ?? 0);

            $tagsDuTouite = $obj->getTagsByTouite($idTouite);

            $html .= "<div class=\"touite\">";

            $html .= "<p><a href=\"?action=utilisateur&id={$idUser}\">{$prenom}</a></p>";
            $html .= "<p>{$message}</p>";

            // Cette boucle permet de parcourir l'ensemble des tags issuent du touites
            if (!empty($tagsDuTouite)) {
                $html .= "<p>Tag  :";
                foreach ($tagsDuTouite as $tag) {
                    $idTag = (int) ($tag['idTag'] ?? 0);
                    $html .= " <a href=\"?action=displayTag&id={$idTag}\">#{$tag['libelle']}</a>";
                    // On filtre le libelle du Tag
                    $libelleTag = filter_var($tag['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    // Intégration d'un lien qui pointe vers la page des tags
                    $html .= "<p>{$message} <a href=\"?action=displayTag&id={$idTag}\">#{$libelleTag}</a></p>";
                }
                $html .= "</p>";
            }
            $html .= "</div>";
        }
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