<?php
namespace touiteur\dispatch;
class Routeur{

    protected string $action;
    protected array $actions = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
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
        return <<<'HTML'
        <!DOCTYPE html>
        <html lang="fr">
        <head> 
            <meta charset="UTF-8">
            <title>Touiteur</title>
        </head>
        <body>
            <h1>Touiteur</h1>
            <a href="?action=default">Accueil</a> |
            <a href="?action=post-touit">Publier un touite</a> |

        </body>
        </html>
        HTML; 
    }


}