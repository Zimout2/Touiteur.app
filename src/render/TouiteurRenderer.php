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
        $messageCourt = substr($this->message, 0, 100);
        $isMessageLong = strlen($this->message) > 100;

        $html = "<div>";
        $html .= "<h4>" . $this->user->getPrenom() . "</h4>";
        if ($isMessageLong) {
            $html .= "<p>" . $messageCourt . "...</p>";
            $html .= "<details>";
            $html .= "  <summary>Voir plus</summary>";
            $html .= "  <p>" . $this->message . "</p>";
            $html .= "</details>";
        } else {
            $html .= "<p>" . $this->message . "</p>";
        }
        // Les tags du touite cliquables
        if (count($this->tags) > 0) {
            $html .= "<p>Tag :";
            foreach ($this->tags as $tag) {
                $html .= " <a href=\"?action=displayTag&id={$tag['idTag']}\">#{$tag['libelle']}</a>";
            }
            $html .= "</p>";
        }
        $html .= "<small>Publié le : " . $this->date . "</small>";
        //$html .= "<small> Like : " . $this->like . "</small>";
        $html .= "<br>";

        return $html;
    }




}