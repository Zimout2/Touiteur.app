<?php

namespace touiteur\action;


class ConnexionTouiteur extends Action {
    public function execute(): string {
        if ($this->http_method === 'GET') {
            return <<<HTML
            <h2>Connexion</h2>
            <form method="post" action="?action=connexion">
                <label>Pseudo : <input type="text" name="prenom" required></label><br>
                <label>Email : <input type="email" name="email" required></label><br>
                <button type="submit">Se connecter</button>
            </form>
            <p>Pas de compte ? <a href="?action=inscription">S'inscrire</a></p>
            HTML;
        }
    $prenom = filter_var($_POST['prenom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = $_POST['email'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "<p>Email invalide. <a href=\"?action=connexion\">Réessayer</a></p>";
    }
    //... 
    }
}