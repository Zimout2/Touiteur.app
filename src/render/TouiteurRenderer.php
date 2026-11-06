<?php

namespace touiteur\render;

use touiteur\entite\User;
use touiteur\entite\Touite;

class TouiteurRenderer implements Renderer {

    private string $message;
    private User $user;
    private string $date;
    private ?int $likes = 0;
    private array $tags;

    public function __construct(Touite $t , array $tags = []) {
        $this->message = $t->getMessage();
        $this->user = $t->getUser();
        $this->date = $t->getDate();
        $this->likes = $t->getLikes();
        $this->tags = $tags;
    }

    public function render(): string {

        $prenom = filter_var($this->user->getPrenom(), FILTER_SANITIZE_SPECIAL_CHARS);
        $idUser = $this->user->getId();

        $message = $this->message;
        foreach ($this->tags as $tag) {
            $libelleTag = $tag['libelle'];
            $idTag = $tag['idTag'];
            $lien = "<a href=\"?action=profil-tag&id={$idTag}\">#{$libelleTag}</a>";
            $message = str_replace("#{$libelleTag}", $lien, $message);
        }

        $messageCourt = substr($message, 0, 100);
        $isMessageLong = strlen($message) > 100;

        $html = "<div>";
        $html .= "<h4><a href='?action=profil&id={$idUser}'>{$prenom}</a></h4>";
        if ($isMessageLong) {
            $html .= "<p>" . $messageCourt . "...</p>";
            $html .= "<details>";
            $html .= "  <summary>Voir plus</summary>";
            $html .= "  <p>" . $message . "</p>";
            $html .= "</details>";
        } else {
            $html .= "<p>" . $message . "</p>";
        }
        // Les tags du touite cliquables
        if (count($this->tags) > 0) {
            $html .= "<p>Tag :";
            foreach ($this->tags as $tag) {
                $html .= " <a href=\"?action=profil-tag&id={$tag['idTag']}\">#{$tag['libelle']}</a>";
            }
            $html .= "</p>";
        }
        $html .= "<small>Publié le : " . $this->date . "</small>";
        //$html .= "<small> Like : " . $this->like . "</small>";
        $html .= "<br>";

        return $html;
    }
}