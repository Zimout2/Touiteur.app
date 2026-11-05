<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\UserRenderer;
use touiteur\render\TouiteurRenderer;
use touiteur\entite\Touite;

class DisplayProfil extends Action {

    public function execute(): string {

        

        $repo = TouiteurRepository::getInstance();

        $html  = "";
        $html .= "<div class='main-container'>";
        $html .= "<h2>Profil</h2>";

        $idUser = $_SESSION['user']['idUser'];
        $profilUser = $repo->getProfilPerso($idUser);
        $infoProfil = $repo->getInfoProfil($idUser);
        $touiteUser = $repo->getTouiteByUser($idUser);

        $html .= "<div class='profil-container'>";
        $html .= "<h2>Profil</h2>";
        if (empty($profilUser)) {
            $html .= "<p>Vous n'existez pas</p>";
        } else {
            $profil = new UserRenderer($profilUser);
            $profil->setNbFollow($infoProfil[0]);
            $profil->setNbSuivi($infoProfil[1]);
            $profil->setNbTouite($infoProfil[2]);
            $html .= $profil->render();
            $html .= "<br>";
            foreach ($touiteUser as $touite) {
                $touiteNew = new Touite($touite[0], $profilUser, $touite[2]);
                $renderTouite = new TouiteurRenderer($touiteNew);
                $html .= $renderTouite->render();
            }
        }
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

        <div class='profil-container'>
            {$html}
        </div>
        HTML;
    }
}