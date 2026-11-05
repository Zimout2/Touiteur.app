<?php

namespace touiteur\action;

class DeconnexionTouiteur extends Action
{
    public function execute(): string
    {
        unset($_SESSION['user']);
        return "<p>Vous êtes déconnecté. <a href=\"?action=accueil\">Accueil</a></p>";
    }
}