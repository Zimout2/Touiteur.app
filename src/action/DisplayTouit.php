<?php

namespace touiteur\action; 

use touiteur\repository\TouiteurRepository;
use touiteur\entite\User;
use touiteur\entite\Touite;
use touiteur\render\TouiteurRenderer ;

class DisplayTouit extends Action {

    public function execute(): string{
        $id = filter_var($_GET['id']?? null , FILTER_VALIDATE_INT);

        if(!$id) {  
            return "<p>Erreur : Identifiant de touite invalide ou manquant.</p>";
        }

        $repo = TouiteurRepository::getInstance();
        //a faire la methode getTOuitById psq y'a meme pas encore le dossier repo j'invente psq y'a meme pas encore la base de donnée
        $ligne = $repo->getTouitById($id);
        if (is_null($ligne)){
            return "<p>le touite n'existe pas </p>";
        }

        $message = $message = $ligne['message'];
        $auteur = new User($ligne['prenom'], '', $ligne['idUser']);
        $touite = new Touite($message, $auteur, $ligne['dateTouite']);
        
        $tags = $repo->getTagsByTouite($id);
        $renderer = new TouiteurRenderer($touite, $tags);
        $html = "<div class=\"touite-detail\">";
        $html .= $renderer->render();


        $html .= "<a href=\"?action=accueil\">← Retour à la liste</a>";
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