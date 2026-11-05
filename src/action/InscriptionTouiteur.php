<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

class InscriptionTouiteur extends Action {
    public function execute(): string{

        if ($this->http_method === 'GET') {
            return <<<HTML
            <h2>Inscription</h2>
            <form method="post" action="?action=inscription">
                <label>Pseudo : <input type="text" name="prenom" maxlength="50" required></label><br>
                <label>Email : <input type="email" name="email" required></label><br>
                <button type="submit">S'inscrire</button>
            </form>
            HTML;
        }

        $prenom = filter_var($_POST['prenom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $email  = $_POST['email'] ?? '';

        if ($prenom === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "<p>Pseudo ou email invalide. <a href=\"?action=inscription\">Réessayer</a></p>";
        }
        $repo = TouiteurRepository::getInstance();
        if ($repo->prenomOuEmailExiste($prenom, $email)) {
            return "<p>utilisateur deja inscrit <a href=\"?action=inscription\">Réessayer</a></p>";
        }
        $id = $repo->addUser($prenom, $email);
        $_SESSION['user'] = ['id_user' => $id, 'prenom' => $prenom, 'email' => $email];
        return "<p>Bienvenue $prenom, vous êtes inscrit et connecté ! <a href=\"?action=accueil\">Accueil</a></p>";

    }
}