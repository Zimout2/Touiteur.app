<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\TouiteurRenderer;
use touiteur\entite\Touite;
use touiteur\entite\User;

class DisplayTouitsAbonne extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?action=connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $repo = TouiteurRepository::getInstance();
        $touitesData = $repo->getTouitesBySubscriptions($userId);

        if (empty($touitesData)) {
            return "<p>Aucun touite à afficher pour vos abonnements.</p>";
        }

        $html = "<div class='touites-abonnements'>";
        
        foreach ($touitesData as $data) {
            $user = new User($data['prenom'], '', (int)$data['idUser']);
            $touite = new Touite(
                $data['message'], 
                $user, 
                $data['dateTouite'], 
                (int)$data['likeTouite'], 
                (int)$data['idTouite']
            );
            $tags = $repo->getTagsByTouite((int)$data['idTouite']);
            $renderer = new TouiteurRenderer($touite, $tags);
            $html .= $renderer->render();
        }
        $html .= "</div>";
        return $html;
    }
}