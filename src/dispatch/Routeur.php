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
        $classe = $this->actions[$this->action];
        $actionObj = new $classe();
        return $this->renderPage($actionObj->execute());
        if (!array_key_exists($this->action, $this->actions)) {
            throw new \Exception("Action '{$this->action}' introuvable");
        }
    }

    public function renderPage(string $html): string {
        //....TODO
        return $html;
    }


}