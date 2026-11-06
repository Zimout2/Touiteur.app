<?php

namespace touiteur\action ;

use touiteur\repository\TouiteurRepository;
use touiteur\entite\Tag;
use touiteur\render\TagRenderer;

class TagTouiteur extends Action {

    public function execute(): string {
        $idTag = $_GET['id'] ?? $_SESSION['tag']['idTag'] ?? null;

        if (!$idTag) {
            return "<div class='profil-container'><p>Aucun tag n'est associé à ce tag.</p></div>";
        }

        $repo = TouiteurRepository::getInstance();


        $tag = $repo->getTagById($idTag);
        $touites = $repo->getTouitesByTag($idTag);

        if (empty($tag)) {
            return "<div class='profil-container'><p>Tag introuvable.</p></div>";
        }

        $t = new Tag($tag['libelle']);
        $renderer = new TagRenderer($t, $touites);
        $html = $renderer->render();

        return <<<HTML
        <style>
            .profil-container {
                max-width: 600px;
                margin: 0 auto;
                text-align: center;
                font-family: Arial, sans-serif;
            }
            .touites-list {
                margin-top: 20px;
            }
        </style>

        <div class='profil-container'>
            {$html}
        </div>
        HTML;
    }
}