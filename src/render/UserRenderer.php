<?php

namespace touiteur\render;

use touiteur\entite\User;

class UserRenderer implements Renderer {
    private User $user;
    private string $prenom;
    private ?int $nb_touite = 0;
    private ?int $nb_suivis = 0;
    private ?int $nb_follow = 0;

    public function __construct(User $user) {
        $this->user = $user;
        $this->prenom = $user->getPrenom();
    }

    public function setNbTouite(int $nbTouite) {
        $this->nb_touite = $nbTouite;
    }

    public function setNbSuivi(int $nbSuivi) {
        $this->nb_suivis = $nbSuivi;
    }

    public function setNbFollow(int $nbFollow) {
        $this->nb_follow = $nbFollow;
    }

    public function render(): string {
        $html = "<h2>" . $this->prenom . "</h2>";
        $html .= "<p><span>Nombre de followers : " . $this->nb_follow . "       </span><span>Nombre de suivis : " . $this->nb_suivis . "</span></p>";
        $html .= "<p>Nombre de touites : " . $this->nb_touite . "</p>";
        $currentUserId = $_SESSION['user_id'] ?? null;
        if ($currentUserId !== null && $currentUserId !== $this->user->getId()) {
            $html .= "<p><a href=\"?action=follow&id=" . $this->user->getId() . "\">Suivre</a></p>";
        }
        $html .= "<h3>Touites</h3>";
        return $html;
    }
}