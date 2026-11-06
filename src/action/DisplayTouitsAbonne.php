<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;
use touiteur\render\TouiteurRenderer;

class DisplayTouitsAbonne extends Action {

    public function execute(): string{
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?action=connexion');
            exit();
        }
        $userId = $_SESSION['user_id'];
        $repo = TouiteurRepository::getInstance();
        $touites = $repo->getTouitesBySubscriptions($userId);

        $renderer = new TouiteurRenderer($touites);
        return $renderer->render();
    }
}