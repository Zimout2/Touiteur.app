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
            <link rel="stylesheet" href="css/style.css">
            <title>Touiteur</title>
        </head>
        <body>
            <header>
            <div class="header-inner">
                <h1><a href="?action=accueil">Touiteur</a></h1>
                <nav>
                    <a href="?action=accueil">Accueil</a>
                    <a href="?action=publication">Publier un touite</a>
                    <a href="?action=displayTag">Tag</a>
                    <a href="?action=utilisateur">Utilisateur</a>
                    <a href="?action=profil">Profil</a>
                    <a href="?action=inscription">Inscription</a>
                    <a href="?action=connexion">Connexion</a>
                    <a href="?action=deconnexion">Déconnexion</a>
                </nav>
            </div>
            </header>
            <div id="content">
                $html
            </div>

        </body>
        </html>
        HTML; 
    }
}