<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;
use touiteur\entite\User;
use touiteur\entite\Touite;
use touiteur\render\TouiteurRenderer;

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
       // Pour chaque touite 
        foreach ($touites as $t) {
            $auteur = new User($t['prenom'], '', $t['idUser']);
            $touite = new Touite($this->retirerTags($t['message']), $auteur, $t['dateTouite']);

            // On récupère les tags de ce touite dans la base
            $tags = $obj->getTagsByTouite($t['idTouite']);

            // Le renderer construit le HTML du touite (auteur, message, tags, date)
            $renderer = new TouiteurRenderer($touite, $tags);
            $html .= $renderer->render();
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