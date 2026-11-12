<?php

namespace touiteur\render;

use touiteur\entite\User;

class UserRenderer implements Renderer {

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function render(): string {
        $html = "<div class='profile-card'>";
        $html .= "<h2>" . htmlspecialchars($this->user->getPrenom()) . "</h2>";
        $currentUserId = $_SESSION['user_id'] ?? null;
        $profileId = $this->user->getId();
        if ($currentUserId !== null && $currentUserId !== $profileId) {
            $html .= "<a href='?action=follow&id={$profileId}' class='btn-follow'>Suivre</a>";
        }
        $html .= "</div>";
        return $html;
    }
}