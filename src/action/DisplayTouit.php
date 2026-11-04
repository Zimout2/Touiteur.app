<?php

namespace touiteur\action; 

use touiteur\repository\TouiteurRepository;

class DisplayTouit extends Action {

    public function execute(): string{
        $id = filter_var($_GET['id']?? null , FILTER_VALIDATE_INT);

        if(!$id) {  
            return "<p>Erreur : Identifiant de touite invalide ou manquant.</p>";
        }

        $repo = TouiteurRepository::getInstance();
        //a faire la methode getTOuitById psq y'a meme pas encore le dossier repo j'invente psq y'a meme pas encore la base de donnée
        $touit = $repo->getTouitById($id);

        $html = "<div class=\"touit-detail\">";
        $html .= "<h2>Touite de " . filter_var($touit['auteur'], FILTER_SANITIZE_STRING) . "</h2>";
        $html .= "<p class=\"texte\">" . nl2br(filter_var($touit['texte'], FILTER_SANITIZE_STRING)) . "</p>";
        $html .= "<div class=\"touit-meta\">";
        $html .= "<p>Publié le : " . $touit['date_publication'] . "</p>";
        $html .= "<p>Score : <strong>" . $touit['score'] . "</strong></p>";
        $html .= "</div>";
        $html .= "<br><a href=\"?action=default\">← Retour à la liste</a>";
        $html .= "</div>";

        return $html;
    }

}