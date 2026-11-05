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

            // Récupération du message en le filtrant pour éviter les injections
            $message = filter_var($t['message'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);


            // Récupération du message en le filtrant pour éviter les injections
            $prenom = filter_var($t['prenom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $idUser = (int) ($t['idUser'] ?? 0);

            $tagsDuTouite = $obj->getTagsByTouite($idTouite);

            $html .= "<div class=\"touite\">";



            // Cette boucle permet de parcourir l'ensemble des tags issuent du touites
            if (!empty($tagsDuTouite)) {
                $html .= "<p><a href=\"?action=utilisateur&id={$idUser}\">{$prenom}</a></p>";
                foreach ($tagsDuTouite as $tag) {
                    $idTag = (int) ($tag['idTag'] ?? 0);
                    // On filtre le libelle du Tag
                    $libelleTag = filter_var($tag['libelle'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                    // Intégration d'un lien qui pointe vers la page des tags
                    $html .= "<p>{$message}<p>";
                    $html .= "</p><strong>Tag</strong> : <a href=\"?action=displayTag&id={$idTag}\">#{$libelleTag}</a> ";
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