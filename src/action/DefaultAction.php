<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;


class DefaultAction extends Action
{
    public function execute(): string {
        //$html = "";
        //if($this ->http_method === 'GET'){
          //  $html .= "<h1>TOUITER</h1>";
          //  $html .= "<p></p>";
            //$html .= "<a href='?Accueil'>Accueil</a>";
            //$html .= "<p></p>";
            //$html .= "<a href='?Utilisateur'>Utilisateur</a>";
            //$html .= "<p></p>";
            //$html .= "<a href='?Tag'>Tag</a>";
            //$html .= "<p></p>";
            //$html .= "<a href='?Profil'>Profil</a>";
            //$html .= "<p></p>";
            //$html .= "<a href='?Pulbier'>Publier</a>";
        //}
        //return $html;

        $touites = TouiteurRepository::getInstance()->getTouites();

        if (count($touites) === 0) {
            return "<p>Aucun touite pour le moment.</p>";
        }
        $html = "<h2>Derniers touites</h2>";
        foreach ($touites as $t) {
            $html .= "<div class=\"touite\">";
            $html .= "<p><a href=\"?action=utilisateur&id={$t['idUser']}\">{$t['prenom']}</a></p>";
            $html .= "<p><a href=\"?action=display-touite&id={$t['idTouite']}\">{$t['message']}</a></p>";
            $html .= "</div>";
        }
        return $html;
    }
}
