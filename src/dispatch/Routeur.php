<?php
namespace touiteur\dispatch;
class Routeur {
    protected string $action;
    protected array $actions = [];

    public function __construct() {
        $this->action = $_GET['action'] ?? 'accueil';
    }

    public function run(): void {
        $html = "";
        if (isset($this->actions[$this->action])) {
            $class = $this->actions[$this->action];
            $play = new $class();
            $html = $play->execute();
            echo $this->renderPage($html);
        } else {
            echo $this->renderPage("</h2>Erreur 404</h2><br><br><h2>Action non trouvé</h2>");
        }
    }

    public function addRoute(string $action, string $class) : self {
        $this->actions[$action] = $class;
        return $this;
    }

    public function renderPage(string $html): string {
        return <<<'HTML'
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
                <a href="?action=tag">Tag</a>
                <p></p>
                <a href="?action=utilisateur">Utilisateur</a>
            </nav>
            <div id="content">
                $html
            </div>

        </body>
        </html>
        HTML;
    }


}