<?php

namespace touiteur\action;

use touiteur\repository\TouiteurRepository;

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
    $user = TouiteurRepository::getInstance()->getUserByPrenomEmail($prenom, $email);
    if (is_null($user)) {
        return "<p>Pseudo ou email incorrect. <a href=\"?action=connexion\">Réessayer</a></p>";
    }

    $_SESSION['user'] = $user;
    $p = "";
    $p .= "<p>Bonjour {$user['prenom']}, vous avez réussis à vous connecter avec succès !<br><br></p>";
    $p .= "<p>Rendez vous maintenant à l'<a href=\"?action=accueil\">accueil</a> de Touiteur !</p>";
    return $p;
    }
}