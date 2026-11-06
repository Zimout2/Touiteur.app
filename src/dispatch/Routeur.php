<?php
namespace touiteur\dispatch;
class Routeur{

    protected string $action;
    protected array $actions = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'accueil';
    }

    public function addRoute(string $action, string $actionClass): Routeur
    {
        $this->actions[$action] = $actionClass;
        return $this;
    }

    public function run(): string
    {
        if (!array_key_exists($this->action, $this->actions)) {
            throw new \Exception("Action '{$this->action}' introuvable");
        }
        $classe = $this->actions[$this->action];
        $actionObj = new $classe();
        return $this->renderPage($actionObj->execute());
        
    }

    public function renderPage(string $html): string {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head> 
            <meta charset="UTF-8">
            <title>Touiteur</title>
        </head>
        <body>
            <h1>Touiteur</h1>
            <nav>
                <a href="?action=accueil">Accueil</a>
                <p></p>
                <a href="?action=publication">Publier un touite</a>
                <p></p>
                <a href="?action=displayTag">Tag</a>
                <p></p>
                <a href="?action=utilisateur">Utilisateur</a>
                <p></p>
                <a href="?action=profil">Profil</a>
                <p></p>
                <a href="?action=follow-tag">Follow Tag</a>
                <p></p>
                <a href="?action=profil-tag">Profil Tag</a>
                <p></p>
                <a href="?action=inscription">Inscription</a>
                <p></p>
                <a href="?action=connexion">Connexion</a>
                <p></p>
                <a href="?action=deconnexion">Déconnexion</a>
                <p></p>
                <a href="?action=subscriptions">Abonnements</a>
            </nav>
            <div id="content">
                $html
            </div>

        </body>
        </html>
        HTML; 
    }
}