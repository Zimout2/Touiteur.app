<?php
namespace touiteur\dispatch ;

class Router{

    protected string $action;
    protected array $actions = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function addRoute(string $action, string $actionClass): Router
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
        //....TODO
        return $html;
    }


}