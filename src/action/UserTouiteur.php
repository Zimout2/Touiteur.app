<?php

namespace touiteur\action ;

//use...


class UserTouiteur extends Action {

    public function execute(): string {
        $html = "";
        if($this ->http_method === 'GET'){
            $html .= "<form method='post' action='?Utilisateur'>";
            $html .= "<label for='f1_name'> Nom de l'utilisateur : </label>";
            $html .= "<input type='text' id='f1_name' name=''playlist_name'' placeholder='' required>";
            $html .= "<button type='submit' name='valider_la_création' value='valid_f1'>Valider</button>";
            $html .= "</form>";
        }
        return $html;
    }
}