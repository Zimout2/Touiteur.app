<?php

namespace touiteur\action ;

class DefaultAction extends Action
{
    public function execute(): string {
        $html = "";
        if($this ->http_method === 'GET'){
            $html .= "<h1>TOUITER</h1>";
            $html .= "<p></p>";
            $html .= "<a href='?Accueil'>Accueil</a>";
            $html .= "<p></p>";
            $html .= "<a href='?Utilisateur'>Utilisateur</a>";
            $html .= "<p></p>";
            $html .= "<a href='?Tag'>Tag</a>";
            $html .= "<p></p>";
            $html .= "<a href='?Profil'>Profil</a>";
            $html .= "<p></p>";
            $html .= "<a href='?Pulbier'>Publier</a>";
        }
        return $html;
    }
}
