<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\UserRenderer;
use touiteur\render\TouiteurRenderer;
use touiteur\entite\Touite;

class DisplayProfil extends Action {

    public function execute(): string {

        if (!isset($_SESSION['user']['idUser'])) {
            return "<div class='profil-container'><p>Veuillez vous connecter pour accéder à votre profil.</p></div>";
        }

        $repo = TouiteurRepository::getInstance();



        $idUser = $_SESSION['user']['idUser'];
        $profilUser = $repo->getProfilPerso($idUser);
        $infoProfil = $repo->getInfoProfil($idUser);
        $touiteUser = $repo->getTouiteByUser($idUser);

        $html = "<div class='profil-container'>";
        $html .= "<h2>Profil</h2>";
        if (empty($profilUser)) {
            $html .= "<p>Vous n'existez tout simplement pas</p>";
        } else {
            $profil = new UserRenderer($profilUser);
            $profil->setNbFollow($infoProfil[0]);
            $profil->setNbSuivi($infoProfil[1]);
            $profil->setNbTouite($infoProfil[2]);
            $html .= $profil->render();
            $html .= "<br><div class='touites-list'>";
            foreach ($touiteUser as $touite) {
                $touiteNew = new Touite($touite['message'], $profilUser, $touite['dateTouite']);
                $renderTouite = new TouiteurRenderer($touiteNew);
                $html .= $renderTouite->render();
            }
            $html .= "</div>";
        }
        $html .= "</div>";
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