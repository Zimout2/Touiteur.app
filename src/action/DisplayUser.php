<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\UserRenderer;
use touiteur\render\TouiteurRenderer;
use touiteur\entite\Touite;

class DisplayUser extends Action {

    public function execute(): string {
        if (!isset($_GET['id'])) {
            return "<p>Utilisateur non spécifié.</p>";
        }
        $idUser = (int)$_GET['id'];
        $repo = TouiteurRepository::getInstance();
        $user = $repo->getProfilPerso($idUser);
        if (!$user) {
            return "<p>Utilisateur introuvable.</p>";
        }

        $infos = $repo->getInfoProfil($idUser);
        $renderer = new UserRenderer($user);
        $renderer->setNbSuivi((int)$infos[0]);
        $renderer->setNbFollow((int)$infos[1]);
        $renderer->setNbTouite((int)$infos[2]);
        $html = $renderer->render();

        if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== $idUser) {
            $idSuiveur = (int)$_SESSION['user_id'];
            if ($repo->isFollowing($idSuiveur, $idUser)) {
                $html .= "<form method='post' action='?action=unfollow'>
                            <input type='hidden' name='id' value='{$idUser}'>
                            <button type='submit'>Se désabonner</button>
                          </form>";
            } else {
                $html .= "<form method='post' action='?action=follow'>
                            <input type='hidden' name='id' value='{$idUser}'>
                            <button type='submit'>Suivre</button>
                          </form>";
            }
        }
        $touitesData = $repo->getTouiteByUser($idUser);
        foreach ($touitesData as $tData) {
            $touite = new Touite($tData['message'], $user, $tData['dateTouite']);
            $tRenderer = new TouiteurRenderer($touite);
            $html .= $tRenderer->render();
        }
        return $html;
    }
}