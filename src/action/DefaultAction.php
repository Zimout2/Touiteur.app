<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;


class DefaultAction extends Action
{
    public function execute(): string {
        $touites = TouiteurRepository::getInstance()->getTouites();

        if (count($touites) === 0) {
            return "<p>Aucun touite pour le moment.</p>";
        }
        $html = "<h2>Derniers touites</h2>";
        foreach ($touites as $t) {
            $html .= "<div class=\"touite\">";
            $html .= "<p><a href=\"?action=utilisateur&id={$t['idUser']}\">{$t['prenom']}</a></p>";
            $html .= "<p>{$t['message']}</p>"; // <a href=\"?action=display-touite&id={$t['idTouite']}\">{$t['message']}</a>
            $html .= "</div>";
        }
        return <<<HTML
        <style>
            .tag-container {
                max-width: 600px;
                margin: 0 auto; /* Centre le conteneur principal sur la page */
                text-align: center; /* Centre le texte à l'intérieur */
                font-family: Arial, sans-serif;
            }
        </style>

        <div class='tag-container'>
            {$html} <!-- Attention à ne pas réinjecter $html dans lui-même, adaptez selon votre variable finale -->
        </div>
        HTML;
    }
}
