<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\UserRenderer;
use touiteur\render\TouiteurRenderer;
use touiteur\entite\Touite;

class   DisplayProfil extends Action {

    public function execute(): string {

        $idUserConnecte = $_SESSION['user']['idUser'] ? $_SESSION['user']['idUser'] : null;
        $idUserProfil   = $_GET['id'] ? $_GET['id'] : $idUserConnecte;

        if (!$idUserProfil) {
            return "<div class='profil-container'><p>Veuillez vous connecter pour accéder à votre profil.</p></div>";
        }

        $repo = TouiteurRepository::getInstance();



        $profilUser = $repo->getProfilPerso($idUserProfil);
        $infoProfil = $repo->getInfoProfil($idUserProfil);
        $touiteUser = $repo->getTouiteByUser($idUserProfil);

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

            //Le bouton follow
            if ($idUserConnecte && $idUserConnecte !== $idUserProfil) {
                $estAbonne = $repo->isFollowing($idUserConnecte, $idUserProfil);

                $html .= "<div class='follow-action' style='margin: 15px 0;'>";
                if ($estAbonne) {
                    $html .= "
                        <form method='POST' action='index.php?action=unfollow'>
                            <input type='hidden' name='idToUnfollow' value='{$idUserProfil}'>
                            <button type='submit' class='btn-unfollow'>Se désabonner</button>
                        </form>";
                } else {
                    $html .= "
                        <form method='POST' action='index.php?action=follow'>
                            <input type='hidden' name='idToFollow' value='{$idUserProfil}'>
                            <button type='submit' class='btn-follow'>S'abonner</button>
                        </form>";
                }
                $html .= "</div>";
            }

            $html .= "<br><div class='touites-list'>";
            foreach ($touiteUser as $touite) {
                $touiteNew = new Touite($touite['message'], $profilUser, $touite['dateTouite']);
                $tags  = $repo->getTagsByTouite($touite['idTouite']);
                $renderTouite = new TouiteurRenderer($touiteNew, $tags);
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
        </style>

        <div class='profil-container'>
            {$html}
        </div>
        HTML;
    }
}