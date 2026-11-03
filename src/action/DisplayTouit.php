<?php

namespace tuoiteur\action; 

class DisplayTouit extends Action {

    public function execute(): string{
        $id = filter_var($_GET['id']?? null , FILTER_VALIDE_INT);

        if(!$id) {
            return "<p>Erreur : Identifiant de touite invalide ou manquant.</p>";
        }

        $repo = TouiteurRepository::getInstance();
        //a faire la methode getTOuitById psq y'a meme pas encore le dossier repo j'invente psq y'a meme pas encore la base de donnée
        $touit = $repo->getTouitById($id);

        $html = "<div class=\"touit-detail\">";
        $html .= "<h2>Touite de " . htmlspecialchars($touit['auteur']) . "</h2>";
        $html .= "<p class=\"texte\">" . nl2br(htmlspecialchars($touit['texte'])) . "</p>";
        $html .= "<div class=\"touit-meta\">";
        $html .= "<p>Publié le : " . $touit['date_publication'] . "</p>";
        $html .= "<p>Score : <strong>" . $touit['score'] . "</strong></p>";
        $html .= "</div>";
        $html .= "<br><a href=\"?action=default\">← Retour à la liste</a>";
        $html .= "</div>";

        return $html;
    }

}