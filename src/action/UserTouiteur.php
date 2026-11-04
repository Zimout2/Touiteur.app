<?php

namespace touiteur\action ;

//use...


class UserTouiteur extends Action {

    public function execute(): string {
        $html = "";
        $html .= "<form method='post' action='?action=utilisateur'>";
        $html .= "<label for='f1_name'> Nom de l'utilisateur : </label>";
        $html .= "<input type='text' id='f1_name' name='username' placeholder='Entrez un nom' required>";
        $html .= "<button type='submit' name='valider_la_création' value='valid_f1'>Valider</button>";
        $html .= "</form>";
        return $html;
    }
}