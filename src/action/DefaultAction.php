<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;
use touiteur\entite\User;
use touiteur\entite\Touite;
use touiteur\render\TouiteurRenderer;

class DefaultAction extends Action {

    /**
     * Méthode permettant de visualiser tout les touites possible
     * @return string renvoie une page html qui correspond à la description de la méthode
     * @throws \Exception
     */
    public function execute(): string {

        // Récuppération des méthodes issue du repo
        $obj = TouiteurRepository::getInstance();

        $touites = $obj->getTouites();

        if (count($touites) === 0) {
            return "<p>Aucun touite pour le moment.</p>";
        }
        $html = "<h2>Derniers touites</h2>";


        foreach ($touites as $t) {
            // Récupération du user lié à ce touites
            $auteur = new User($t['prenom'], '', $t['idUser']);
            // Récupération des touites du user sans les tags
            $touite = new Touite($t['message'], $auteur, $t['dateTouite']);

            // Récupération des tags du touites
            $tags = $obj->getTagsByTouite($t['idTouite']);

            // Envoie des données collecter au renderer
            $renderer = new TouiteurRenderer($touite, $tags);
            $html .= $renderer->render();
        }

        // Cette html permet d'avoir html lisible et avec un ajout de css
        // permettant d'être centré sans être en dessous du menu
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